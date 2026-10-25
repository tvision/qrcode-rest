<?php

declare(strict_types=1);

namespace Terravision\QRCode\Tests;

use PHPUnit\Framework\TestCase;
use Terravision\QRCode\Exception\BadRequestException;
use Terravision\QRCode\QrCodeFactory;

final class QrCodeFactoryTest extends TestCase
{
    private QrCodeFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new QrCodeFactory();
    }

    public function testCreatesPng(): void
    {
        $qr = $this->factory->create('liuggio', 150, 'png');
        self::assertSame('image/png', $qr->getMimeType());
        self::assertNotSame('', $qr->getBody());
        self::assertSame("\x89PNG", substr($qr->getBody(), 0, 4));
    }

    public function testCreatesJpeg(): void
    {
        $qr = $this->factory->create('liuggio', 150, 'jpeg');
        self::assertSame('image/jpeg', $qr->getMimeType());
        self::assertSame("\xFF\xD8\xFF", substr($qr->getBody(), 0, 3));
    }

    public function testRejectsInvalidSize(): void
    {
        $this->expectException(BadRequestException::class);
        $this->factory->create('x', 10, 'png');
    }

    public function testEscapedAndUnescapedPayloadsMatch(): void
    {
        $encoded = '1415038AC0%7CTRVBUS00003599571%7CBCR%7CCIA%7CROMTER%7C14150916A%7C1%7C1%7C0%7C0%7C3744119900';
        $plain = '1415038AC0|TRVBUS00003599571|BCR|CIA|ROMTER|14150916A|1|1|0|0|3744119900';

        self::assertSame($plain, rawurldecode($encoded));

        $a = $this->factory->create(rawurldecode($encoded), 150, 'png')->getBody();
        $b = $this->factory->create($plain, 150, 'png')->getBody();
        self::assertSame($a, $b);
    }
}
