<?php

namespace Paygreen\Tests\Unit\Payment\Model;

use Paygreen\Sdk\Payment\V2\Model\Address;
use Paygreen\Sdk\Payment\V2\Model\AddressInterface;
use Paygreen\Sdk\Payment\V2\Model\Customer;
use Paygreen\Sdk\Payment\V2\Model\CustomerInterface;
use Paygreen\Sdk\Payment\V2\Model\Order;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanGetAndSetId()
    {
        $order = new Order();
        $order->setReference('order-1');

        $this->assertEquals('order-1', $order->getReference());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCurrency()
    {
        $order = new Order();
        $order->setCurrency('EUR');

        $this->assertEquals('EUR', $order->getCurrency());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetAmount()
    {
        $order = new Order();
        $order->setAmount(1000);

        $this->assertEquals(1000, $order->getAmount());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetShippingAddress()
    {
        $address = new Address();
        
        $order = new Order();
        $order->setShippingAddress($address);

        $this->assertInstanceOf(AddressInterface::class, $order->getShippingAddress());
        $this->assertEquals($address, $order->getShippingAddress());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetBillingAddress()
    {
        $address = new Address();

        $order = new Order();
        $order->setBillingAddress($address);

        $this->assertInstanceOf(AddressInterface::class, $order->getBillingAddress());
        $this->assertEquals($address, $order->getBillingAddress());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCustomer()
    {
        $customer = new Customer();

        $order = new Order();
        $order->setCustomer($customer);

        $this->assertInstanceOf(CustomerInterface::class, $order->getCustomer());
        $this->assertEquals($customer, $order->getCustomer());
    }
}