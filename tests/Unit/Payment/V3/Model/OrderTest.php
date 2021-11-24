<?php

namespace Paygreen\Tests\Unit\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\AddressInterface;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\BuyerInterface;
use Paygreen\Sdk\Payment\V3\Model\Order;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    public function testCanGetAndSetId()
    {
        $order = new Order();
        $order->setId('id-1');

        $this->assertEquals('id-1', $order->getId());
    }
    
    public function testCanGetAndSetRefence()
    {
        $order = new Order();
        $order->setReference('order-1');

        $this->assertEquals('order-1', $order->getReference());
    }

    public function testCanGetAndSetCurrency()
    {
        $order = new Order();
        $order->setCurrency('eur');

        $this->assertEquals('eur', $order->getCurrency());
    }

    public function testCanGetAndSetAmount()
    {
        $order = new Order();
        $order->setAmount(1000);

        $this->assertEquals(1000, $order->getAmount());
    }

    public function testCanGetAndSetShippingAddress()
    {
        $address = new Address();

        $order = new Order();
        $order->setShippingAddress($address);

        $this->assertInstanceOf(AddressInterface::class, $order->getShippingAddress());
        $this->assertEquals($address, $order->getShippingAddress());
    }

    public function testCanGetAndSetBuyer()
    {
        $customer = new Buyer();

        $order = new Order();
        $order->setBuyer($customer);

        $this->assertInstanceOf(BuyerInterface::class, $order->getBuyer());
        $this->assertEquals($customer, $order->getBuyer());
    }
}
