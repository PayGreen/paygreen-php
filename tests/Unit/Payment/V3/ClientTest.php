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

    public function testRequestListConfig()
    {
        $this->client->listPaymentConfig();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/payment-configs', $request->getUri()->getPath());
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
        $buyer->setPhoneNumber('0102030405');

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
        $this->assertEquals($buyer->getId(), $content->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->phone_number);

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

    public function testRequestUpdateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setId('buyerId');
        $buyer->setReference('buyerReference');
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setPhoneNumber('0102030405');

        $this->client->updateBuyer($buyer);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/buyers/buyerReference', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->email);
        $this->assertEquals($buyer->getFirstName(), $content->first_name);
        $this->assertEquals($buyer->getLastName(), $content->last_name);
        $this->assertEquals($buyer->getId(), $content->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->phone_number);
    }

    public function testRequestCreateOrder()
    {
        $buyer = new Buyer();
        $buyer->setId('buyerId');
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setPhoneNumber('0102030405');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");

        $buyer->setBillingAddress($address);

        $order = new Order();
        $order->setBuyer($buyer);
        $order->setReference('SDK-ORDER-123');
        $order->setAmount(1000);
        $order->setCurrency('EUR');
        $order->setShippingAddress($address);

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setPaymentMode(PaymentModeEnum::SPLIT);
        $paymentOrder->setAutoCapture(true);
        $paymentOrder->setFirstAmount(100);
        $paymentOrder->setMerchantInitiated(true);
        $paymentOrder->setInstrumentId(12415);
        $paymentOrder->setPreviousOrderId(12345);
        $paymentOrder->setIntegrationMode(IntegrationModeEnum::HOSTED_FIELDS);
        $paymentOrder->setOrder($order);

        $this->client->createPaymentOrder($paymentOrder);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->buyer->email);
        $this->assertEquals($buyer->getFirstName(), $content->buyer->first_name);
        $this->assertEquals($buyer->getLastName(), $content->buyer->last_name);
        $this->assertEquals($buyer->getId(), $content->buyer->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->buyer->phone_number);

        $this->assertEquals($order->getReference(), $content->reference);
        $this->assertEquals($order->getAmount(), $content->amount);
        $this->assertEquals($order->getCurrency(), $content->currency);

        $this->assertEquals($paymentOrder->getPaymentMode(), $content->mode);
        $this->assertEquals($paymentOrder->getAutoCapture(), $content->auto_capture);
        $this->assertEquals($paymentOrder->getIntegrationMode(), $content->integration_mode);
    }

    public function testRequestCreateWithBuyerOrder()
    {
        $buyer = new Buyer();
        $buyer->setReference('buyerReference');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");

        $order = new Order();
        $order->setBuyer($buyer);
        $order->setReference('SDK-ORDER-123');
        $order->setAmount(1000);
        $order->setCurrency('EUR');
        $order->setShippingAddress($address);


        $paymentOrder = new PaymentOrder();
        $paymentOrder->setPaymentMode(PaymentModeEnum::INSTANT);
        $paymentOrder->setAutoCapture(true);
        $paymentOrder->setIntegrationMode(IntegrationModeEnum::HOSTED_FIELDS);
        $paymentOrder->setOrder($order);

        $this->client->createPaymentOrder($paymentOrder);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getReference(), $content->buyer);

        $this->assertEquals($order->getReference(), $content->reference);
        $this->assertEquals($order->getAmount(), $content->amount);
        $this->assertEquals($order->getCurrency(), $content->currency);

        $this->assertEquals($paymentOrder->getPaymentMode(), $content->mode);
        $this->assertEquals($paymentOrder->getAutoCapture(), $content->auto_capture);
        $this->assertEquals($paymentOrder->getIntegrationMode(), $content->integration_mode);
    }

    public function testRequestGetOrder()
    {
        $order = new Order();
        $order->setReference('SDK-ORDER-123');

        $this->client->getPaymentOrder($order->getReference());
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/SDK-ORDER-123', $request->getUri()->getPath());
    }

    public function testRequestUpdateOrder()
    {
        $order = new Order();
        $order->setReference('SDK-ORDER-123');

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setOrder($order);
        $paymentOrder->setPartialAllowed(true);

        $this->client->updatePaymentOrder($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/SDK-ORDER-123', $request->getUri()->getPath());
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

    public function testRequestCaptureOrder()
    {
        $order = new Order();
        $order->setReference('SDK-ORDER-123');

        $this->client->capturePaymentOrder($order->getReference());
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/SDK-ORDER-123/capture', $request->getUri()->getPath());
    }

    public function testRequestRefundOrder()
    {
        $order = new Order();
        $order->setReference('SDK-ORDER-123');

        $this->client->refundPaymentOrder($order->getReference());
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/SDK-ORDER-123/refund', $request->getUri()->getPath());
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
}
