<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\PaymentLink;
use PHPUnit\Framework\TestCase;

class PaymentLinkTest extends TestCase
{
    use ClientTrait;

    public function testRequestCreatePaymentLink()
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

        $paymentLink = new PaymentLink();
        $paymentLink->setAmount(1000);
        $paymentLink->setBuyer($buyer);
        $paymentLink->setCurrency('eur');
        $paymentLink->setReference('my-order-reference');
        $paymentLink->setExpiresAt('2024-05-17T13:46:16');
        $this->client->createPaymentLink($paymentLink);

        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-links', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->buyer->email);
        $this->assertEquals($buyer->getFirstName(), $content->buyer->first_name);
        $this->assertEquals($buyer->getLastName(), $content->buyer->last_name);
        $this->assertEquals($buyer->getReference(), $content->buyer->reference);
        $this->assertEquals($buyer->getPhoneNumber(), $content->buyer->phone_number);
        $this->assertEquals($paymentLink->getReference(), $content->reference);
        $this->assertEquals($paymentLink->getAmount(), $content->amount);
        $this->assertEquals($paymentLink->getCurrency(), $content->currency);
        $this->assertEquals($paymentLink->getExpiresAt(), $content->expires_at);
    }

    public function testRequestListPaymentLink()
    {
        $this->client->listPaymentLink('sh_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            '/payment/payment-links?shop_id=sh_0000&max_per_page=20&page=1',
            $request->getUri()->getPath() . '?' . $request->getUri()->getQuery()
        );
    }

    public function testRequestGetPaymentLink()
    {
        $this->client->getPaymentLink('pl_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/payment-links/pl_0000', $request->getUri()->getPath());
    }

    public function testRequestCancelPaymentLink()
    {
        $this->client->cancelPaymentLink('pl_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-links/pl_0000/cancel', $request->getUri()->getPath());
    }

    public function testRequestActivatePaymentLink()
    {
        $this->client->activatePaymentLink('pl_0000');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-links/pl_0000/activate', $request->getUri()->getPath());
    }
}