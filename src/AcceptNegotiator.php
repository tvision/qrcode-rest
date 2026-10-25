<?php

declare(strict_types=1);

namespace Terravision\QRCode;

use Terravision\QRCode\Exception\BadRequestException;

final class AcceptNegotiator
{
    /** @var list<string> */
    private const DEFAULT_PRIORITIES = ['image/png', 'image/jpeg', 'image/jpg'];

    /** @var array<string, string> */
    private const MIME_TO_FORMAT = [
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
        'image/jpg' => 'jpeg',
        'image/gif' => 'gif',
        'image/svg+xml' => 'svg',
        'image/webp' => 'png',
    ];

    public function resolve(?string $acceptHeader): string
    {
        $acceptHeader = trim((string) $acceptHeader);
        if ($acceptHeader === '' || $acceptHeader === '*/*') {
            return 'png';
        }

        $candidates = [];
        foreach (explode(',', $acceptHeader) as $part) {
            $mime = strtolower(trim(explode(';', $part, 2)[0]));
            if ($mime === '' || $mime === '*/*') {
                $candidates[] = 'png';
                continue;
            }
            if (isset(self::MIME_TO_FORMAT[$mime])) {
                $candidates[] = self::MIME_TO_FORMAT[$mime];
            }
        }

        if ($candidates === []) {
            throw new BadRequestException(sprintf(
                'Accept header "%s" is not valid; try %s',
                $acceptHeader,
                implode(', ', self::DEFAULT_PRIORITIES)
            ));
        }

        return $candidates[0];
    }
}
