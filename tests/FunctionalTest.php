<?php

namespace Terravision\QRCode\Tests;

use Silex\WebTestCase;

class FunctionalTest extends WebTestCase
{
    public function createApplication()
    {
        $env='test';
        return require __DIR__ . '/../web/dev.php';
    }

    /**
     * @test
     */
    public function shouldRetrieveAnImage()
    {
        $client = $this->createClient();
        $client->request('GET','/liuggio');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode(),
            'Upload form failed to load'
        );
    }

    /**
     * @test
     */
    public function shouldRetrieveAValidPNGImage()
    {
        $client = $this->createClient();
        $client->request('GET','/liuggio');

        $response = $client->getResponse();

        $this->assertTrue(
            $response->headers->contains('Content-Type', 'image/png'),
            $response->headers,
            'Headers don\'t contain image/png as content-type'
        );
    }

    /**
     * @test
     */
    public function shouldRetrieveSizedPNGImage()
    {
        $client = $this->createClient();
        $client->request('GET','/liuggio?size=300');

        $this->assertEquals(
            $client->getResponse()->getContent(),
            file_get_contents(__DIR__.'/fixture_liuggio_300.png'),
            'Response doesn\'t match the 300 sized fixture'
        );
    }

    /**
     * @test
     */
    public function shouldEscapedValueAndUnescapeValueBeTheSame()
    {
        $client = $this->createClient();

        $client->request('GET','/1415038AC0%7CTRVBUS00003599571%7ABCR%7CCIA%7CROMTER%7C14150916A%7C1%7C1%7C0%7C0%7C3744119900');
        $responseEscaped = $client->getResponse()->getContent();

        $client->request('GET','/1415038AC0|TRVBUS00003599571zBCR|CIA|ROMTER|14150916A|1|1|0|0|3744119900');
        $responseUnescaped = $client->getResponse()->getContent();

        $this->assertEquals(
            $responseEscaped,
            $responseUnescaped,
            'Response From Unescaped Should be the same for escaped'
        );
    }
}
