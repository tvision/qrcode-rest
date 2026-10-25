# qrcode-rest

Thin REST service that turns a URL path into a QR-code image.

Used by Terravision API-MS and Booking ticket/email templates as:

`https://qrcode.terravision.eu/{payload}`

## Contract

| Item | Behavior |
|------|----------|
| Route | `GET /{content}` — path is the QR payload (supports `\|` and `%7C`) |
| Default size | `150` (`?size=` between 21 and 1200) |
| Formats | `Accept: image/png` (default), `image/jpeg`, `image/gif`, `image/svg+xml` |

## Stack

- PHP **8.4.27** (Docker image pinned for CVE-2026-109618 / CVE-2026-109619)
- [`endroid/qr-code`](https://packagist.org/packages/endroid/qr-code) `^6.1.3`
- nginx + php-fpm via Docker Compose

## Run locally

```bash
docker compose up --build
```

Then:

```bash
curl -o /tmp/qr.png http://127.0.0.1:8080/liuggio
curl -H 'Accept: image/jpeg' -o /tmp/qr.jpg 'http://127.0.0.1:8080/liuggio?size=300'
```

Override host port with `QRCODE_PORT=9080 docker compose up --build`.

## Tests

```bash
docker compose run --rm php vendor/bin/phpunit
```

## Legacy

Branch `master` @ `1acee8f` is the Jessie / Silex / PHP 5.6 production tip.
This branch replaces that app in-repo for a modern runtime; cutover of `qrcode.terravision.eu` is separate.
