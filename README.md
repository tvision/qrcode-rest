QR-code-rest-api
================

A  REST micro application that provides QR-Codes.

###  Feature

- it escapes the resource
- Fast.
- Small
- Single Resp. Principle.
- Accept header for different format.

### Install

``` bash
git clone tvision/qrcode-rest
composer install
phpunit
```

## Run

`php -S 0.0.0.0:8080 web/dev.php`

in production link the root to `web/prod.php`


#### On the browser:

`http://0.0.0.0:8080/143241234123412341234`

#### With the size parameters:

`http://0.0.0.0:8080/143241234123412341234`

#### Changing the format via Accept header:

`curl -H "Accept: image/jpg"  http://0.0.0.0:8080/143241234123412341234?size=300 > a.jpg`

