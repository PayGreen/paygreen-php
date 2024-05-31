<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Paygreen\Sdk\Payment\V3\Model\SellingContract;
use PHPUnit\Framework\TestCase;

class SellingContractTest extends TestCase
{
    use ClientTrait;

    public function testRequestListSellingContract()
    {
        $this->client->listSellingContract(
            'sh_123456',
            [],
            [
                'max_per_page' => 5,
                'page' => 2
            ]
        );

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/selling-contracts?shop_id=sh_123456&max_per_page=5&page=2',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
    }

    public function testRequestUpdateSellingContract()
    {
        $sellingContract = new SellingContract();
        $sellingContract->setId('sc_123456');
        $sellingContract->setMaxAmount(300);

        $this->client->updateSellingContact($sellingContract);
        $request = $this->client->getLastRequest();
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/selling-contracts/sc_123456', $request->getUri()->getPath());
        $this->assertEquals(300, $content->max_amount);
    }

    public function testRequestCreateSellingContract()
    {
        $sellingContract = new SellingContract();
        $sellingContract->setShopId('sh_123456');
        $sellingContract->setNumber('12345611155');
        $sellingContract->setMcc(4555);
        $sellingContract->setMaxAmount(15000);
        $sellingContract->setType('vads');
        $sellingContract->setIban('PK90AIVK7112008308800030');

        $this->client->createSellingContract($sellingContract);
        $request = $this->client->getLastRequest();
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/selling-contracts', $request->getUri()->getPath());
        $this->assertEquals('sh_123456', $content->shop_id);
        $this->assertEquals('12345611155', $content->number);
        $this->assertEquals(4555, $content->mcc);
        $this->assertEquals(15000, $content->max_amount);
        $this->assertEquals('vads', $content->type);
        $this->assertEquals('PK90AIVK7112008308800030', $content->iban);
    }
}