<?php

namespace Terravision\QRCode;

use Terravision\QRCode\Exception\BadRequestFormatNotValid;
use Terravision\QRCode\Exception\BadRequestImageSizeNotValid;
use Terravision\QRCode\Infrastructure\EndroidQRCodeGenerator;

class QRCodeFactory
{
    private $qrCodeCreator;
    private $maxSize;

    function __construct(QRCodeCreatorInterface $qrCodeCreator = null, $maxSize = 1200)
    {
        $this->qrCodeCreator = $qrCodeCreator?: new EndroidQRCodeGenerator();
        $this->maxSize = $maxSize;
    }

    public function createQRCode($string, $size, $format)
    {
        $this->assertCorrectFormat($format);
        $this->assertCorrectSize($size);

        return  $this->qrCodeCreator->generate($string, $size, $format);
    }

    private function assertCorrectFormat($format)
    {
        $formats = $this->qrCodeCreator->getAvailableFormats();
        if (!in_array($format, $formats)) {
            throw new BadRequestFormatNotValid(sprintf("%s is not a valid format [%s]", $format, join(',', $formats)));
        }
    }

    private function assertCorrectSize($size)
    {
        $size = (int) $size;
        $minSize = 20;
        if ($size <= $minSize || $size > $this->maxSize) {
            throw new BadRequestImageSizeNotValid(sprintf("%d is not a valid Size [%d-%d]", $size, $minSize, $this->maxSize));
        }
    }
} 