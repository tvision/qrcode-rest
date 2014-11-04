<?php

namespace Terravision\QRCode;

interface QRCodeCreatorInterface
{
    /**
     * @param string $text
     * @param int    $size
     * @param string $format
     *
     * @return QRCode
     */
    public function generate($text, $size, $format);

    /**
     * @return array of the available formats like ['png']
     */
    public function getAvailableFormats();

} 