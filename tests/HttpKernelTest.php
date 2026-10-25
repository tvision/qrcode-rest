<?php

declare(strict_types=1);

namespace Terravision\QRCode\Tests;

use PHPUnit\Framework\TestCase;
use Terravision\QRCode\HttpKernel;

final class HttpKernelTest extends TestCase
{
    public function testReturnsPngForPayload(): void
    {
        $kernel = new HttpKernel();

        ob_start();
        $kernel->handle('GET', '/liuggio', '', 'image/png');
        $body = (string) ob_get_clean();

        self::assertSame("\x89PNG", substr($body, 0, 4));
    }

    public function testRootHelpText(): void
    {
        $kernel = new HttpKernel();

        ob_start();
        $kernel->handle('GET', '/', '', null);
        $body = (string) ob_get_clean();

        self::assertStringContainsString('You should ask me something', $body);
    }
}
