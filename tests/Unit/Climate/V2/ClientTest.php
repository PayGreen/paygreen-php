<?php

namespace Paygreen\Tests\Unit\Climate\V2;

use Http\Client\Curl\Client;
use Paygreen\Sdk\Climate\V2\Model\CartItem;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\Address;
use Paygreen\Sdk\Climate\V2\Environment;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClientTest extends TestCase
{
    /** @var \Paygreen\Sdk\Climate\V2\Client */
    private $client;

    public function setUp()
    {
        $client = new Client();

        $environment = new Environment(
            'client_id',
            'SANDBOX',
            2
        );

        $logger = new NullLogger();

        $this->client = new \Paygreen\Sdk\Climate\V2\Client($client, $environment, $logger);
    }

    public function testLogin()
    {
        $this->client->login(
            'client_id',
            'username',
            'password'
        );
        $request = $this->client->getLastRequest();
        
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/login', $request->getUri()->getPath());
    }

    public function testRefresh()
    {
        $this->client->refresh(
            'client_id',
            'refresh_token'
        );
        $request = $this->client->getLastRequest();
        

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/login', $request->getUri()->getPath());
    }

    public function testGetAccountInfos()
    {
        $this->client->getAccountInfos('client_id');
        $request = $this->client->getLastRequest();
        
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/client_id', $request->getUri()->getPath());
    }

    public function testGetUserInfos()
    {
        $this->client->getUserInfos('client_id', 'username');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/client_id/user/username', $request->getUri()->getPath());
    }

    public function testGetCurrentUserInfos()
    {
        $this->client->getCurrentUserInfos();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/me/user/me', $request->getUri()->getPath());
    }
    
    public function testGetFavoriteProject()
    {
        $this->client->getFavoriteProject('1');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/carbon/public/projects', $request->getUri()->getPath());   
    }

    public function testCreateEmptyFootprint()
    {
        $this->client->createEmptyFootprint('footprint_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints', $request->getUri()->getPath());
    }

    public function testGetFootprint()
    {
        $this->client->getFootprint('footprint_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id', $request->getUri()->getPath());
    }

    public function testCloseFootprint()
    {
        $this->client->closeFootprint('footprint_id', 'CLOSED');
        $request = $this->client->getLastRequest();

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id', $request->getUri()->getPath());
    }

    public function testUserContributeFootprint()
    {
        $this->client->userContribute('footprint_id', 500);
        $request = $this->client->getLastRequest();

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id', $request->getUri()->getPath());
    }

    public function testAddWebBrowsingData()
    {
        $webBrowsingData = new WebBrowsingData();
        $webBrowsingData->setUserAgent('Application:my-application/1.0.0 sdk:1.0.0 php:5.6;');
        $webBrowsingData->setPageCount(85);
        $webBrowsingData->setImageCount(15);
        $webBrowsingData->setDevice('Laptop');
        $webBrowsingData->setBrowser('Firefox');
        $webBrowsingData->setTime(4789);
        $webBrowsingData->setExternalId('my-external-id');
        
        $this->client->addWebBrowsingData('footprint_id', $webBrowsingData);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id/web', $request->getUri()->getPath());
    }

    public function testAddDeliveryData()
    {
        $shippedFrom = new Address();
        $shippedFrom->setAddress('1 rue de Paris');
        $shippedFrom->setZipCode('75000');
        $shippedFrom->setCity('Paris');
        $shippedFrom->setCountry('France');

        $shippedTo = new Address();
        $shippedTo->setAddress('1 rue de Paris');
        $shippedTo->setZipCode('75000');
        $shippedTo->setCity('Paris');
        $shippedTo->setCountry('France');
        
        $deliveryData = new DeliveryData();
        $deliveryData->setTotalWeightInKg(45.50);
        $deliveryData->setShippedFrom($shippedFrom);
        $deliveryData->setShippedTo($shippedTo);
        $deliveryData->setTransportationExternalId('1-28022');
        $deliveryData->setDeliveryService('Colissimo');

        $this->client->addDeliveryData('footprint_id', $deliveryData);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id/delivery', $request->getUri()->getPath());
    }

    public function testAddProductsData()
    {
        $cartItems = array();
        
        $cartItem = new CartItem();
        $cartItem->setProductReference('my-product');
        $cartItem->setQuantity(1);
        $cartItem->setPriceWithoutTaxes(10000);
        $cartItems[] = $cartItem;
        
        $this->client->addProductsData('footprint_id', $cartItems);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id/product-cart', $request->getUri()->getPath());
    }

    public function testCreateProductReference()
    {
        $this->client->createProductReference(
            'my-product-external-reference',
            'my-product-name'
        );
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/products/references', $request->getUri()->getPath());
    }

    public function testRemoveDeliveryData()
    {
        $this->client->removeDeliveryData('footprint-id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint-id/delivery', $request->getUri()->getPath());
    }

    public function testRemoveProductData()
    {
        $this->client->removeProductData('footprint-id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint-id/products', $request->getUri()->getPath());

        $this->client->removeProductData(
            'footprint-id',
            'my-product-external-reference'
        );
        
        $request = $this->client->getLastRequest();

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals(
            '/carbon/footprints/footprint-id/products/my-product-external-reference',
            $request->getUri()->getPath()
        );
    }

    public function testExportProductCatalog()
    {
        $file = tmpfile();
        $fileMetadata = stream_get_meta_data($file);
        $filePath = $fileMetadata['uri'];
        
        $this->client->exportProductCatalog($filePath);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/products/catalog', $request->getUri()->getPath());
    }

    public function testGetTokenFootprint()
    {
        $this->client->getTokenFootprint('footprint_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/tokens/footprint/footprint_id', $request->getUri()->getPath());
    }

    public function testGetStatisticReport()
    {
        $this->client->getStatisticReport();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/carbon/statistics/reports', $request->getUri()->getPath());
        $this->assertEquals(null, $request->getBody()->getContents());
    }

    public function testReserveCarbon()
    {
        $this->client->reserveCarbon('footprint_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id/contribution', $request->getUri()->getPath());
    }

    public function testListEmissionFactor()
    {
        $this->client->listEmissionFactor();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/carbon/emissionFactors', $request->getUri()->getPath());
        $this->assertEquals('page=1&limit=25', $request->getUri()->getQuery());
    }

    public function testGetEmissionFactor()
    {
        $this->client->getEmissionFactor('emission_factor_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/carbon/emissionFactors/emission_factor_id', $request->getUri()->getPath());
    }
}