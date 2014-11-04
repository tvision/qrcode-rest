<?php

namespace Terravision\QRCode\Infrastructure;

use Terravision\QRCode\QRCode;
use Terravision\QRCode\QRCodeCreatorInterface;
use Endroid\QrCode\QrCode as EndroidQRCode;

class EndroidQRCodeGenerator implements QRCodeCreatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generate($text, $size, $format)
    {
        $qrCode = new EndroidQRCode();
        $qrCode->setText($text);
        $qrCode->setSize($size);
        $qrCode->setPadding(2);

        return new QRCode($text,  $qrCode->get($format), $size, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableFormats()
    {
        return array(EndroidQRCode::IMAGE_TYPE_GIF, EndroidQRCode::IMAGE_TYPE_PNG,
            EndroidQRCode::IMAGE_TYPE_JPEG, EndroidQRCode::IMAGE_TYPE_WBMP);
    }
} 