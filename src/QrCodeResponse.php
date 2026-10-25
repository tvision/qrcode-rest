<?php

declare(strict_types=1);

namespace Terravision\QRCode;

final class QrCodeResponse
{
    public function __construct(
        private readonly string $body,
        private readonly string $mimeType,
    ) {
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
