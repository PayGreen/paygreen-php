<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Paygreen\Sdk\Payment\V3\Model\Operation;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    use ClientTrait;

    public function testRequestGetOperation()
    {
        $this->client->getOperation('op_123456');

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/operations/op_123456', $request->getUri()->getPath());
    }

    public function testRequestListOperation()
    {
        $this->client->listOperation(
            [
                'instrument_id' => 'ins_123456'
            ],
            [
                'max_per_page' => 5,
                'page' => 2,
            ]
        );

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/operations?instrument_id=ins_123456&max_per_page=5&page=2',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
    }

    public function testRequestUpdateOperation()
    {
        $operation = new Operation();
        $operation->setAmount(2000);

        $this->client->updateOperation('op_123456', $operation);
        $request = $this->client->getLastRequest();
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/operations/op_123456', $request->getUri()->getPath());
        $this->assertEquals(2000, $content->amount);
    }
}