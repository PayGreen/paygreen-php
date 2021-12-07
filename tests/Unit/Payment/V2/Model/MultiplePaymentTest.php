<?php

namespace Paygreen\Tests\Unit\Payment\V2\Model;

use Paygreen\Sdk\Payment\V2\Model\MultiplePayment;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class MultiplePaymentTest extends TestCase
{
    public function testCanGetAndSetCycle()
    {
        $orderDetails = new MultiplePayment();
        $orderDetails->setCycle(40);

        $this->assertEquals(40, $orderDetails->getCycle());
    }

    public function testCanGetAndSetCount()
    {
        $orderDetails = new MultiplePayment();
        $orderDetails->setCount(12);

        $this->assertEquals(12, $orderDetails->getCount());
    }

    public function testCanGetAndSetDay()
    {
        $orderDetails = new MultiplePayment();
        $orderDetails->setDay(20);

        $this->assertEquals(20, $orderDetails->getDay());
    }

    public function testCanGetAndSetStartAt()
    {
        $orderDetails = new MultiplePayment();
        $orderDetails->setStartAt(1637227163);

        $this->assertEquals(1637227163, $orderDetails->getStartAt());
    }

    public function testCanGetAndSetFirstAmount()
    {
        $orderDetails = new MultiplePayment();
        $orderDetails->setFirstAmount(6500);

        $this->assertEquals(6500, $orderDetails->getFirstAmount());
    }
}
