<?php

namespace Paygreen\Tests\Unit\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\AddressInterface;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use PHPUnit\Framework\TestCase;

final class BuyerTest extends TestCase
{
    public function testCanGetAndSetId()
    {
        $buyer = new Buyer();
        $buyer->setId('buyer-1');

        $this->assertEquals('buyer-1', $buyer->getId());
    }

    public function testCanGetAndSetRefence()
    {
        $buyer = new Buyer();
        $buyer->setReference('reference-1');

        $this->assertEquals('reference-1', $buyer->getReference());
    }

    public function testCanGetAndSetCompanyName()
    {
        $buyer = new Buyer();
        $buyer->setCompanyName('PayGreen');

        $this->assertEquals('PayGreen', $buyer->getCompanyName());
    }

    public function testCanGetAndSetFirstName()
    {
        $buyer = new Buyer();
        $buyer->setFirstName('Laurent');

        $this->assertEquals('Laurent', $buyer->getFirstName());
    }

    public function testCanGetAndSetLastName()
    {
        $buyer = new Buyer();
        $buyer->setLastName('Barre');

        $this->assertEquals('Barre', $buyer->getLastName());
    }

    public function testCanGetAndSetEmail()
    {
        $buyer = new Buyer();
        $buyer->setEmail('customer@test.fr');

        $this->assertEquals('customer@test.fr', $buyer->getEmail());
    }

    public function testCanGetAndSetCountryCode()
    {
        $buyer = new Buyer();
        $buyer->setCountryCode('FR');

        $this->assertEquals('FR', $buyer->getCountryCode());
    }

    public function testCanGetAndSetBillingAddress()
    {
        $address = new Address();

        $buyer = new Buyer();
        $buyer->setBillingAddress($address);

        $this->assertInstanceOf(AddressInterface::class, $buyer->getBillingAddress());
        $this->assertEquals($address, $buyer->getBillingAddress());
    }
}
