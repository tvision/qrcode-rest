<?php

namespace Terravision\QRCode;

class QRCode
{
    private $binary;
    private $text;
    private $format;
    private $size;

    function __construct($text, $binary, $size, $format)
    {
        $this->binary = $binary;
        $this->format = $format;
        $this->size = $size;
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getBinary()
    {
        return $this->binary;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->binary;
    }
} 