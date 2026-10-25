<?php

declare(strict_types=1);

namespace Terravision\QRCode\Tests;

use PHPUnit\Framework\TestCase;
use Terravision\QRCode\AcceptNegotiator;
use Terravision\QRCode\Exception\BadRequestException;

final class AcceptNegotiatorTest extends TestCase
{
    private AcceptNegotiator $negotiator;

    protected function setUp(): void
    {
        $this->negotiator = new AcceptNegotiator();
    }

    public function testDefaultsToPng(): void
    {
        self::assertSame('png', $this->negotiator->resolve(null));
        self::assertSame('png', $this->negotiator->resolve(''));
        self::assertSame('png', $this->negotiator->resolve('*/*'));
    }

    public function testResolvesJpegAndSvg(): void
    {
        self::assertSame('jpeg', $this->negotiator->resolve('image/jpeg'));
        self::assertSame('jpeg', $this->negotiator->resolve('image/jpg'));
        self::assertSame('svg', $this->negotiator->resolve('image/svg+xml'));
    }

    public function testRejectsUnknownAccept(): void
    {
        $this->expectException(BadRequestException::class);
        $this->negotiator->resolve('text/html');
    }
}
