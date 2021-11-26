<?php

namespace Paygreen\Tests\Unit\Core\Response;

use GuzzleHttp\Psr7\Response;
use Paygreen\Sdk\Core\Response\TextResponse;
use PHPUnit\Framework\TestCase;

final class TextResponseTest extends TestCase
{
    public function testCanGetDataJsonResponse()
    {
        $response = new Response(200, [], 'ok');

        $jsonResponse = new TextResponse($response);

        $this->assertEquals('ok', $jsonResponse->getData());
    }

    public function testCanConvertToArrayJsonResponse()
    {
        $response = new Response(200, [], 'ok');

        $jsonResponse = new TextResponse($response);

        $this->assertTrue(is_array($data = $jsonResponse->toArray()));

        $this->assertEquals(200, $data['http_code']);

        $this->assertEquals('ok', $data['data']);
    }
}
