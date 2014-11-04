<?php

namespace Terravision\QRCode\Tests;

use Terravision\QRCode\QRCodeFactory;

class QRCodeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \Terravision\QRCode\Exception\BadRequestImageSizeNotValid
     */
    public function shouldRiseErrorIfSizeIsTooBig()
    {
        $factory = new QRCodeFactory();
        $factory->createQRCode('a', 0, 'png');
    }

    /**
     * @test
     * @expectedException \Terravision\QRCode\Exception\BadRequestFormatNotValid
     */
    public function shouldRiseErrorWithWrongFormat()
    {
        $factory = new QRCodeFactory();
        $factory->createQRCode('a', 99, 'xxx');
    }

    /**
     * @test
     */
    public function shouldCreateAQRCode()
    {
        $factory = new QRCodeFactory();
        $this->assertInstanceOf('Terravision\QRCode\QRCode', $factory->createQRCode('a', 99, 'png'));
    }
}
 