<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Shop;
use PHPUnit\Framework\TestCase;

class ShopTest extends TestCase
{
    use ClientTrait;

    public function testRequestGetShop()
    {
        $this->client->getShop('shop-123');

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/shops/shop-123', $request->getUri()->getPath());
    }

    public function testRequestListShopWithoutParams()
    {
        $this->client->listShop();

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('max_per_page=20&page=1', $request->getUri()->getQuery());
    }

    public function testRequestListShopWithFilters()
    {
        $this->client->listShop(
            [
                'name' => 'My shop name'
            ]
        );

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('name=My+shop+name&max_per_page=20&page=1', $request->getUri()->getQuery());
    }

    public function testRequestListShopWithPagination()
    {
        $this->client->listShop(
            null,
            [
                'max_per_page' => 5,
                'page' => 2,
            ]
        );

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('max_per_page=5&page=2', $request->getUri()->getQuery());
    }

    public function testRequestCreateShopWithDeprecatedParams()
    {
        $this->client->createShop('my-shop', 'shop-national-id');

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('my-shop', $content->name);
        $this->assertEquals('shop-national-id', $content->national_id);
    }

    public function testRequestCreateShopWithShop()
    {
        date_default_timezone_set('UTC');

        $shop = (new Shop())
            ->setName('name')
            ->setNationalId('123456789')
            ->setMcc(123)
            ->setAnnualProcessingVolume(111)
            ->setAverageTransactionValue(222)
            ->setHighestTransactionValue(333)
            ->setActivityCategories(['FOOD'])
            ->setActivityDescription('description')
            ->setAddress((new Address())
                ->setStreetLineOne('street')
                ->setStreetLineTwo('street2')
                ->setCity('city')
                ->setPostalCode('76000')
                ->setCountryCode('FR')
            )
            ->setCommercialName('commercial name')
            ->setCreationDate(new \DateTime('2020-01-01'))
            ->setEconomicModel(['B2B'])
            ->setLegalCategory('artisan')
            ->setPrimaryActivity('energie')
            ->setProductType(['TYPE1'])
            ->setWebsiteUrl('https://www.example.com')
            ->setLegalNoticeUrl('https://www.example.com/legal');


        $this->client->createShop(null, null, $shop);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('name', $content->name);
        $this->assertEquals("123456789", $content->national_id);
        $this->assertEquals(123, $content->mcc);
        $this->assertEquals(111, $content->annual_processing_volume);
        $this->assertEquals(222, $content->average_transaction_value);
        $this->assertEquals(333, $content->highest_transaction_value);
        $this->assertEquals(['FOOD'], $content->activity_categories);
        $this->assertEquals('description', $content->activity_description);
        $this->assertEquals('commercial name', $content->commercial_name);
        $this->assertEquals('2020-01-01', $content->creation_date);
        $this->assertEquals(['B2B'], $content->economic_model);
        $this->assertEquals('artisan', $content->legal_category);
        $this->assertEquals('energie', $content->primary_activity);
        $this->assertEquals(['TYPE1'], $content->product_type);
        $this->assertEquals('https://www.example.com', $content->website_url);
        $this->assertEquals('https://www.example.com/legal', $content->legal_notice_url);
        $this->assertEquals('street', $content->address->line_1);
    }

    public function testRequestCreateShopWithShopAndDeprecatedParamsUnused()
    {
        $shop = (new Shop())
            ->setName('name')
            ->setNationalId(123456789)
            ->setMcc(123);

        $this->client->createShop('deprecatedName', 'depreacatedNI', $shop);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('name', $content->name);
        $this->assertEquals(123456789, $content->national_id);
        $this->assertEquals(123, $content->mcc);
    }

    public function testRequestCreateShopWithShopAndDeprecatedParamsUsed()
    {
        $shop = (new Shop())
            ->setMcc(123);

        $this->client->createShop('deprecatedName', 'deprecatedNI', $shop);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('deprecatedName', $content->name);
        $this->assertEquals('deprecatedNI', $content->national_id);
        $this->assertEquals(123, $content->mcc);
    }

    public function testUpdateShop()
    {
        $shop = (new Shop())
            ->setName('name')
            ->setNationalId('123456789')
        ;

        $this->client->updateShop('sh_1234', $shop);

        $request = $this->client->getLastRequest();
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/account/shops/sh_1234', $request->getUri()->getPath());
        $this->assertEquals("name", $content->name);
        $this->assertEquals("123456789", $content->national_id);
    }
}