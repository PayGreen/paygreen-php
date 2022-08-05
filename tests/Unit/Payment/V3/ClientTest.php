<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Http\Mock\Client;
use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\PaymentModeEnum;
use Paygreen\Sdk\Payment\V3\Environment;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\Order;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Model\SellingContract;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class ClientTest extends TestCase
{
    /**
     * @var \Paygreen\Sdk\Payment\V3\Client
     */
    private $client;

    public function setUp()
    {
        $client = new Client();

        $environment = new Environment(
            'my_shop_id',
            'my_secret_key',
            'SANDBOX',
            3
        );

        $logger = new NullLogger();

        $this->client = new \Paygreen\Sdk\Payment\V3\Client($client, $environment, $logger);
    }

    public function testRequestAuthenticate()
    {
        $this->client->authenticate();
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/auth/authentication/my_shop_id/secret-key', $request->getUri()->getPath());
    }

    public function testRequestListPaymentConfig()
    {
        $this->client->listPaymentConfig();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/payment-configs', $request->getUri()->getPath());
    }

    public function testRequestCreatePaymentConfig()
    {
        $this->client->createPaymentConfig(
            'bank_card',
            array('config1', 'config2'),
            'sel_0000',
            'sh_0000'
        );
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-configs', $request->getUri()->getPath());
        $this->assertEquals('bank_card', $content->platform);
        $this->assertEquals(array('config1', 'config2'), $content->config);
        $this->assertEquals('sel_0000', $content->selling_contract);
        $this->assertEquals("sh_0000", $content->shop_id);
    }

    public function testRequestGetPublicKey()
    {
        $publicKey = 'pk_xxxxxxxxxxx';
        $this->client->getPublicKey($publicKey);

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/auth/public-keys/pk_xxxxxxxxxxx', $request->getUri()->getPath());
    }

    public function testRequestCreateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setId(uniqid());
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setCountryCode('FR');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");

        $buyer->setBillingAddress($address);

        $this->client->createBuyer($buyer);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/buyers', $request->getUri()->getPath());
        $this->assertEquals("my_shop_id", $content->shop_id);
        $this->assertEquals($buyer->getEmail(), $content->email);
        $this->assertEquals($buyer->getFirstName(), $content->first_name);
        $this->assertEquals($buyer->getLastName(), $content->last_name);
        $this->assertEquals($buyer->getReference(), $content->reference);
        $this->assertEquals($buyer->getCountryCode(), $content->country);
    }

    public function testRequestGetBuyer()
    {
        $buyer = new Buyer();
        $buyer->setReference('buyerReference');

        $this->client->getBuyer($buyer);
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/buyers/buyerReference', $request->getUri()->getPath());
    }

    public function testRequestListBuyers()
    {
        $this->client->listBuyer('sh_0000');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/buyers',  $request->getUri()->getPath());
        $this->assertEquals('sh_0000', $content->shop_id);
    }

    public function testRequestUpdateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setId('buyerId');
        $buyer->setReference('buyerReference');
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setCountryCode('FR');

        $this->client->updateBuyer($buyer);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/buyers/buyerId', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->email);
        $this->assertEquals($buyer->getFirstName(), $content->first_name);
        $this->assertEquals($buyer->getLastName(), $content->last_name);
        $this->assertEquals($buyer->getReference(), $content->reference);
        $this->assertEquals($buyer->getCountryCode(), $content->country);
    }

    public function testRequestCreatePaymentOrder()
    {
        $buyer = new Buyer();
        $buyer->setReference('my-user-reference');
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setCountryCode('FR');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterrand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");

        $buyer->setBillingAddress($address);

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setAmount(1000);
        $paymentOrder->setBuyer($buyer);
        $paymentOrder->setCurrency('eur');
        $paymentOrder->setReference('my-order-reference');
        $paymentOrder->setShippingAddress($address);

        $this->client->createPaymentOrder($paymentOrder);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->buyer->email);
        $this->assertEquals($buyer->getFirstName(), $content->buyer->first_name);
        $this->assertEquals($buyer->getLastName(), $content->buyer->last_name);
        $this->assertEquals($buyer->getReference(), $content->buyer->reference);
        $this->assertEquals($buyer->getCountryCode(), $content->buyer->country);

        $this->assertEquals($paymentOrder->getReference(), $content->reference);
        $this->assertEquals($paymentOrder->getAmount(), $content->amount);
        $this->assertEquals($paymentOrder->getCurrency(), $content->currency);
    }

    public function testRequestCreateWithBuyerOrder()
    {
        $buyer = new Buyer();
        $buyer->setId('buy_0000');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setAmount(1000);
        $paymentOrder->setBuyer($buyer);
        $paymentOrder->setCurrency('eur');
        $paymentOrder->setReference('my-order-reference');
        $paymentOrder->setShippingAddress($address);

        $this->client->createPaymentOrder($paymentOrder);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getId(), $content->buyer);

        $this->assertEquals($paymentOrder->getReference(), $content->reference);
        $this->assertEquals($paymentOrder->getAmount(), $content->amount);
        $this->assertEquals($paymentOrder->getCurrency(), $content->currency);
    }

    public function testRequestGetPaymentOrder()
    {
        $this->client->getPaymentOrder('po_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/po_0000', $request->getUri()->getPath());
    }

    public function testRequestGetPaymentOrders()
    {
        $order = new Order();
        $order->setReference('SDK-ORDER-123');

        $this->client->getPaymentOrders($order->getReference(), 'shop-id');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals('SDK-ORDER-123', $content->reference);
        $this->assertEquals('shop-id', $content->shop_id);
    }

    public function testRequestUpdatePaymentOrder()
    {
        $paymentOrder = new PaymentOrder();
        $paymentOrder->setId('po_0000');
        $paymentOrder->setPartialAllowed(true);

        $this->client->updatePaymentOrder($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/po_0000', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->isPartialAllowed(), $content->partial_allowed);
    }

    public function testRequestCreateInstrument()
    {
        $instrument = new Instrument();
        $instrument->setWithAuthorization(true);
        $instrument->setType('bank_card');
        $instrument->setToken('card_token');

        $this->client->createInstrument($instrument);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/instruments', $request->getUri()->getPath());

        $this->assertEquals($instrument->getToken(), $content->token);
        $this->assertEquals($instrument->getType(), $content->type);
        $this->assertEquals($instrument->isWithAuthorization(), $content->with_authorization);
    }

    public function testRequestUpdateInstrument()
    {
        $instrument = new Instrument();
        $instrument->setReference('instrumentReference');
        $instrument->setWithAuthorization(true);
        $instrument->setType('bank_card');
        $instrument->setToken('card_token');

        $this->client->updateInstrument($instrument);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/instruments/instrumentReference', $request->getUri()->getPath());

        $this->assertEquals($instrument->getToken(), $content->token);
        $this->assertEquals($instrument->getType(), $content->type);
        $this->assertEquals($instrument->isWithAuthorization(), $content->with_authorization);
    }

    public function testRequestDeleteInstrument()
    {
        $instrument = new Instrument();
        $instrument->setReference('instrumentReference');

        $this->client->deleteInstrument($instrument->getReference());
        $request = $this->client->getLastRequest();

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/payment/instruments/instrumentReference', $request->getUri()->getPath());
    }

    public function testRequestGetInstrument()
    {
        $instrument = new Instrument();
        $instrument->setReference('instrumentReference');

        $this->client->getInstrument($instrument->getReference());
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/instruments/instrumentReference', $request->getUri()->getPath());
    }

    public function testRequestListInstruments()
    {
        $this->client->listInstrument('buy_0000');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/instruments',  $request->getUri()->getPath());
        $this->assertEquals('buy_0000', $content->buyer_id);
    }

    public function testRequestCaptureOrder()
    {
        $this->client->capturePaymentOrder('po_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/po_0000/capture', $request->getUri()->getPath());
    }

    public function testRequestRefundOrder()
    {
        $this->client->refundPaymentOrder('po_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/po_0000/refund', $request->getUri()->getPath());
    }

    public function testRequestCreateListener()
    {
        $this->client->createListener(
            'webhook',
            array('payment_order.authorized'),
            'https://my-listener-url.fr'
        );
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/notifications/listeners', $request->getUri()->getPath());
        $this->assertEquals('webhook', $content->type);
        $this->assertEquals(array('payment_order.authorized'), $content->events);
        $this->assertEquals('https://my-listener-url.fr', $content->url);
    }

    public function testRequestUpdateListener()
    {
        $this->client->updateListener('lis_12345', 'https://my-listener-url.fr');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/notifications/listeners/lis_12345', $request->getUri()->getPath());
        $this->assertEquals('https://my-listener-url.fr', $content->url);
    }

    public function testRequestGetListener()
    {
        $this->client->getListener('lis_12345');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/notifications/listeners/lis_12345', $request->getUri()->getPath());
    }

    public function testRequestGetListenerByShop()
    {
        $this->client->listListenerByShop('sh_12345');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            '/notifications/listeners?shop_id=sh_12345',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
    }

    public function testRequestDeleteListener()
    {
        $this->client->deleteListener('lis_12345');
        $request = $this->client->getLastRequest();

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals('/notifications/listeners/lis_12345', $request->getUri()->getPath());
    }

    public function testRequestGetNotificationsByListener()
    {
        $this->client->getNotificationsByListener('lis_12345');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            '/notifications/?listener_id=lis_12345',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
    }

    public function testRequestReplayNotification()
    {
        $this->client->replayNotification('ntf_12345');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/notifications/ntf_12345/replay',  $request->getUri()->getPath());
    }

    public function testRequestCreateEvent()
    {
        $this->client->createEvent('log', 'log content');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/events',  $request->getUri()->getPath());
        $this->assertEquals('log', $content->type);
        $this->assertEquals('log content', $content->content);
    }

    public function testRequestGetSellingContracts()
    {
        $this->client->getSellingContracts('sh_0000');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/selling-contracts',  $request->getUri()->getPath());
        $this->assertEquals('sh_0000', $content->shop_id);
    }

    public function testRequestCreateSellingContract()
    {
        $sellingContract = new SellingContract();
        $sellingContract->setNumber('10');
        $sellingContract->setMcc(123);
        $sellingContract->setMaxAmount(1000);
        $sellingContract->setType('vads');

        $this->client->createSellingContract($sellingContract, 'sh_0000');

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/selling-contracts',  $request->getUri()->getPath());
        $this->assertEquals('sh_0000', $content->shop_id);
        $this->assertEquals('10', $content->number);
        $this->assertEquals(123, $content->mcc);
        $this->assertEquals(1000, $content->max_amount);
        $this->assertEquals('vads', $content->type);
    }
}
