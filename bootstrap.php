<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Terravision\QRCode\QRCodeFactory;
use KPhoen\Provider\NegotiationServiceProvider;
use Terravision\QRCode\Exception\BadRequestAcceptHeaderNotValid;

$app = new Silex\Application();

$app['default.qrcode.size']=150;

$app->register(new NegotiationServiceProvider());

$app["format.negotiator"]->registerFormat('svg', ['image/svg+xml']);
$app["format.negotiator"]->registerFormat('png', ['image/png']);
$app["format.negotiator"]->registerFormat('jpeg', ['image/jpeg', 'image/jpg']);
$app['format.qrcode.priorities'] = ['image/png', 'image/jpg'];

$app->get( '/', function() {
        return "You should ask me something to create like /barcode";
});


$app->get( '/{content}', function($content, Request $request) use ($app)
    {
        $formatNegotiator = $app["format.negotiator"];

        $mimeType = $formatNegotiator->getBest($request->headers->get('Accept'), $app['format.qrcode.priorities']);

        if (null == $mimeType) {
              throw new BadRequestAcceptHeaderNotValid($request->headers->get('Accept'));
        }
        $format = $formatNegotiator->getFormat($mimeType->getValue());
        $size = ((int) $request->query->get('size'))?:$app['default.qrcode.size'];

        $factory = new QRCodeFactory();
        $qrCode = $factory->createQRCode($content, $size, $format);

        return $qrCode;
    })
    ->assert('content', '.+')
    ->after(function (Request $request, Response $response) use ($app)
    {
        $formatNegotiator = $app["format.negotiator"];
        $mimeType = $formatNegotiator->getBest($request->headers->get('Accept'), $app['format.qrcode.priorities']);
        if (null !== $mimeType) {
            $headers = ['Content-Type'=>$mimeType->getValue()];
            $response->headers->add($headers);
        }
    });

return $app;