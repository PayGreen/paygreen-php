<?php

namespace Paygreen\Tests\Unit\Core\Response;

use GuzzleHttp\Psr7\Response;
use Paygreen\Sdk\Core\Exception\ResponseMalformedException;
use Paygreen\Sdk\Core\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use stdClass;

final class JsonResponseTest extends TestCase
{
    public function testCanGetDataJsonResponse()
    {
        $response = new Response(200, [], json_encode(['test' => true]));

        $jsonResponse = new JsonResponse($response);

        $this->assertInstanceOf(
            stdClass::class,
            $data = $jsonResponse->getData()
        );

        $this->assertEquals(true, $data->test);
    }

    public function testCanConvertToArrayJsonResponse()
    {
        $response = new Response(200, [], json_encode(['test' => true]));

        $jsonResponse = new JsonResponse($response);

        $this->assertTrue(is_array($data = $jsonResponse->toArray()));

        $this->assertEquals(200, $data['http_code']);

        $this->assertEquals(true, $data['data']['test']);
    }

    public function testCanGetEmptyDataJsonResponse()
    {
        $response = new Response();

        $jsonResponse = new JsonResponse($response);

        $this->assertInstanceOf(
            stdClass::class,
            $jsonResponse->getData()
        );
    }

    public function testInvalidJsonResponse()
    {
        $response = new Response(200, [], 'not json');

        $jsonResponse = new JsonResponse($response);

        $this->expectException(ResponseMalformedException::class);

        $jsonResponse->getData();
    }
}
