QR-code-rest-api
================

A  REST micro application that provides QR-Codes.

###  Feature

- It escapes the resource (smaller qrcode).
- Fast.
- Small.
- Single Resp. Principle.
- Accept header for different format.

### Install

``` bash
git clone git@github.com:tvision/qrcode-rest.git
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

## Deploy with Capistrano

`gem install`

`cap deploy:setup HOSTS="your.server.com"`

`cap deploy HOSTS="your.server.com"`

## Nginx virtual hosts:

``` nginx

server {
     listen 80;

    server_name qrcode.your.server.com;
    root "/home/deploy/public_html/qrcode-rest/current/web";


    location = / {
        try_files @site @site;
    }

    #all other locations try other files first and go to our front controller if none of them exists
    location / {
        try_files $uri $uri/ @site;
    }

    #return 404 for all php files as we do have a front controller
    location ~ \.php$ {
        return 404;
    }

    location @site {
        fastcgi_pass   unix:/home/deploy/deploy_fpm.sock;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root/prod.php;
        #uncomment when running via https
        #fastcgi_param HTTPS on;
    }
}
```