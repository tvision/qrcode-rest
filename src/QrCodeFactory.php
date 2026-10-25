<?php

declare(strict_types=1);

namespace Terravision\QRCode;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\GifWriter;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\WriterInterface;
use Terravision\QRCode\Exception\BadRequestException;

final class QrCodeFactory
{
    private const DEFAULT_SIZE = 150;
    private const MIN_SIZE = 21;
    private const MAX_SIZE = 1200;
    private const MARGIN = 2;

    /** @var array<string, class-string<WriterInterface>> */
    private const WRITERS = [
        'png' => PngWriter::class,
        'gif' => GifWriter::class,
        'svg' => SvgWriter::class,
    ];

    public function create(string $data, int $size, string $format): QrCodeResponse
    {
        $format = strtolower($format);
        $size = $size > 0 ? $size : self::DEFAULT_SIZE;

        if ($size < self::MIN_SIZE || $size > self::MAX_SIZE) {
            throw new BadRequestException(sprintf(
                '%d is not a valid size [%d-%d]',
                $size,
                self::MIN_SIZE,
                self::MAX_SIZE
            ));
        }

        if ($format === 'jpeg' || $format === 'jpg') {
            return $this->createJpeg($data, $size);
        }

        if (!isset(self::WRITERS[$format])) {
            throw new BadRequestException(sprintf(
                '%s is not a valid format [%s,jpeg]',
                $format,
                implode(',', array_keys(self::WRITERS))
            ));
        }

        $writerClass = self::WRITERS[$format];
        /** @var WriterInterface $writer */
        $writer = new $writerClass();
        $result = $this->write($writer, $data, $size);

        return new QrCodeResponse($result->getString(), $result->getMimeType());
    }

    private function createJpeg(string $data, int $size): QrCodeResponse
    {
        $png = $this->write(new PngWriter(), $data, $size);
        $image = imagecreatefromstring($png->getString());
        if ($image === false) {
            throw new BadRequestException('Failed to convert QR code to JPEG');
        }

        ob_start();
        imagejpeg($image, null, 90);
        imagedestroy($image);
        $binary = (string) ob_get_clean();

        return new QrCodeResponse($binary, 'image/jpeg');
    }

    private function write(WriterInterface $writer, string $data, int $size): ResultInterface
    {
        $qrCode = new QrCode(
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: $size,
            margin: self::MARGIN,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        );

        return $writer->write($qrCode);
    }
}
