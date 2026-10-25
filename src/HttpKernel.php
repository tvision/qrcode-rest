<?php

declare(strict_types=1);

namespace Terravision\QRCode;

use Terravision\QRCode\Exception\BadRequestException;

final class HttpKernel
{
    public function __construct(
        private readonly QrCodeFactory $factory = new QrCodeFactory(),
        private readonly AcceptNegotiator $negotiator = new AcceptNegotiator(),
    ) {
    }

    public function handle(string $method, string $path, string $queryString, ?string $acceptHeader): void
    {
        $method = strtoupper($method);
        if ($method !== 'GET' && $method !== 'HEAD') {
            $this->sendError(405, 'Method Not Allowed');
            return;
        }

        $path = rawurldecode($path);
        $path = '/' . ltrim($path, '/');

        if ($path === '/' || $path === '') {
            header('Content-Type: text/plain; charset=UTF-8');
            http_response_code(200);
            if ($method === 'GET') {
                echo 'You should ask me something to create like /barcode';
            }
            return;
        }

        $content = ltrim($path, '/');
        if ($content === '') {
            $this->sendError(400, 'Missing QR payload');
            return;
        }

        parse_str($queryString, $query);
        $size = isset($query['size']) ? (int) $query['size'] : 0;

        try {
            $format = $this->negotiator->resolve($acceptHeader);
            $qr = $this->factory->create($content, $size, $format);
        } catch (BadRequestException $e) {
            $this->sendError(400, $e->getMessage());
            return;
        }

        header('Content-Type: ' . $qr->getMimeType());
        header('Cache-Control: public, max-age=86400');
        header('Content-Length: ' . (string) strlen($qr->getBody()));
        http_response_code(200);
        if ($method === 'GET') {
            echo $qr->getBody();
        }
    }

    private function sendError(int $status, string $message): void
    {
        http_response_code($status);
        header('Content-Type: text/plain; charset=UTF-8');
        echo $message;
    }
}
