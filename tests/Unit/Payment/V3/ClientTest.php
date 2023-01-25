<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Http\Mock\Client;
use Paygreen\Sdk\Payment\V3\Environment;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\Listener;
use Paygreen\Sdk\Payment\V3\Model\PaymentConfig;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Model\Shop;
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
        $paymentConfig = new PaymentConfig();
        $paymentConfig->setPlatform('bank_card');
        $paymentConfig->setConfig(array('config1', 'config2'));
        $paymentConfig->setSellingContractId('sel_0000');
        $paymentConfig->setCurrency('eur');
        $this->client->createPaymentConfig($paymentConfig, 'sh_0000');
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
        $buyer->setReference(uniqid());
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setPhoneNumber('0102030405');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");
        $address->setState("Normandie");

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
        $this->assertEquals($buyer->getPhoneNumber(), $content->phone_number);
    }

    public function testRequestGetBuyer()
    {
        $this->client->getBuyer('buy_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/buyers/buy_0000', $request->getUri()->getPath());
    }

    public function testRequestListBuyer()
    {
        $this->client->listBuyer();
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/buyers',  $request->getUri()->getPath());
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
        $this->assertEquals('/payment/buyers/buyerId', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->email);
        $this->assertEquals($buyer->getFirstName(), $content->first_name);
        $this->assertEquals($buyer->getLastName(), $content->last_name);
        $this->assertEquals($buyer->getReference(), $content->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->phone_number);
    }

    public function testRequestCreatePaymentOrder()
    {
        $buyer = new Buyer();
        $buyer->setReference('my-user-reference');
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setPhoneNumber('0102030405');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterrand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");
        $address->setState("Normandie");

        $buyer->setBillingAddress($address);

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setAmount(1000);
        $paymentOrder->setBuyer($buyer);
        $paymentOrder->setCurrency('eur');
        $paymentOrder->setReference('my-order-reference');
        $paymentOrder->setShippingAddress($address);
        $paymentOrder->setMetadata(array('cart_id' => 15));
        $paymentOrder->setCancelUrl('https://www.heypongo.com?cancel');
        $paymentOrder->setReturnUrl('https://www.heypongo.com?success');

        $this->client->createPaymentOrder($paymentOrder);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->buyer->email);
        $this->assertEquals($buyer->getFirstName(), $content->buyer->first_name);
        $this->assertEquals($buyer->getLastName(), $content->buyer->last_name);
        $this->assertEquals($buyer->getReference(), $content->buyer->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->buyer->phone_number);
        $this->assertEquals($paymentOrder->getReference(), $content->reference);
        $this->assertEquals($paymentOrder->getAmount(), $content->amount);
        $this->assertEquals($paymentOrder->getCurrency(), $content->currency);
        $this->assertEquals($paymentOrder->getMetadata(), (array)$content->metadata);
        $this->assertEquals($paymentOrder->getCancelUrl(), 'https://www.heypongo.com?cancel');
        $this->assertEquals($paymentOrder->getReturnUrl(), 'https://www.heypongo.com?success');
    }

    public function testRequestCreatePaymentOrderMarketPlace()
    {
        $buyer = new Buyer();
        $buyer->setReference('my-user-reference');
        $buyer->setFirstName('John');
        $buyer->setLastName('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setPhoneNumber('0102030405');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterrand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");
        $address->setState("Normandie");

        $buyer->setBillingAddress($address);

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setAmount(1000);
        $paymentOrder->setBuyer($buyer);
        $paymentOrder->setCurrency('eur');
        $paymentOrder->setReference('my-order-reference');
        $paymentOrder->setInstrument('ins_0000');
        $paymentOrder->setShippingAddress($address);
        $paymentOrder->setMetadata(array('cart_id' => 15));
        $paymentOrder->setFees(10);
        $paymentOrder->setShopId("sh_xxx");

        $this->client->createPaymentOrder($paymentOrder);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->buyer->email);
        $this->assertEquals($buyer->getFirstName(), $content->buyer->first_name);
        $this->assertEquals($buyer->getLastName(), $content->buyer->last_name);
        $this->assertEquals($buyer->getReference(), $content->buyer->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->buyer->phone_number);
        $this->assertEquals($paymentOrder->getReference(), $content->reference);
        $this->assertEquals($paymentOrder->getAmount(), $content->amount);
        $this->assertEquals($paymentOrder->getCurrency(), $content->currency);
        $this->assertEquals($paymentOrder->getMetadata(), (array)$content->metadata);
        $this->assertEquals($paymentOrder->getInstrument(), $content->instrument);
        $this->assertEquals($paymentOrder->getFees(), $content->fees);
        $this->assertEquals($paymentOrder->getShopId(), $content->shop_id);
    }

    public function testRequestCreatePaymentOrderWithBuyerOrder()
    {
        $buyer = new Buyer();
        $buyer->setId('buy_0000');

        $address = new Address();
        $address->setStreetLineOne("107 allée Francois Mitterand");
        $address->setPostalCode("76100");
        $address->setCity("Rouen");
        $address->setCountryCode("FR");
        $address->setState("Normandie");

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

    public function testRequestListPaymentOrder()
    {
        $this->client->listPaymentOrder('SDK-ORDER-123', 'sh_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            '/payment/payment-orders?shop_id=sh_0000&reference=SDK-ORDER-123',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
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
        $this->assertEquals('/payment/instruments?buyer_id=buy_0000',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
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

    public function testRequestCancelPaymentOrder()
    {
        $this->client->cancelPaymentOrder('po_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders/po_0000/cancel', $request->getUri()->getPath());
    }

    public function testRequestCreateListener()
    {
        $listener = new Listener();
        $listener->setType('webhook');
        $listener->setEvents(array('payment_order.authorized'));
        $listener->setUrl('https://my-listener-url.fr');

        $this->client->createListener($listener);
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
        $this->client->listListener('sh_12345');
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
        $this->client->listNotification('lis_12345');
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
        $this->assertEquals('/notifications/ntf_12345/replay', $request->getUri()->getPath());
    }

    public function testRequestCreateEvent()
    {
        $this->client->createEvent('log', 'log content');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/events', $request->getUri()->getPath());
        $this->assertEquals('log', $content->type);
        $this->assertEquals('log content', $content->content);
    }

    public function testRequestGetTransaction()
    {
        $this->client->getTransaction('transaction-123');

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/transactions/transaction-123', $request->getUri()->getPath());
    }

    public function testRequestListTransaction()
    {
        $this->client->listTransaction(
            'sh_0000',
            'sh_0001',
            10,
            2
        );

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/transactions?requester_shop_id=sh_0000&shop_id=sh_0001&max_per_page=10&page=2',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
    }

    public function testRequestGetShop()
    {
        $this->client->getShop('shop-123');

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/shops/shop-123', $request->getUri()->getPath());
    }

    public function testRequestListShop()
    {
        $this->client->listShop();

        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
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

        $this->client->createShop('deprecatedName', 'depreacatedNI', $shop);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/account/shops', $request->getUri()->getPath());
        $this->assertEquals('deprecatedName', $content->name);
        $this->assertEquals('depreacatedNI', $content->national_id);
        $this->assertEquals(123, $content->mcc);
    }
}
