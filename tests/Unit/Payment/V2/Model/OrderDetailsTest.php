<?php

namespace Paygreen\Tests\Unit\Payment\V2\Model;

use Paygreen\Sdk\Payment\V2\Model\OrderDetails;
use PHPUnit\Framework\TestCase;

final class OrderDetailsTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanGetAndSetCycle()
    {
        $orderDetails = new OrderDetails();
        $orderDetails->setCycle(40);

        $this->assertEquals(40, $orderDetails->getCycle());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCount()
    {
        $orderDetails = new OrderDetails();
        $orderDetails->setCount(12);

        $this->assertEquals(12, $orderDetails->getCount());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetDay()
    {
        $orderDetails = new OrderDetails();
        $orderDetails->setDay(20);

        $this->assertEquals(20, $orderDetails->getDay());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetStartAt()
    {
        $orderDetails = new OrderDetails();
        $orderDetails->setStartAt(1637227163);

        $this->assertEquals(1637227163, $orderDetails->getStartAt());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetFirstAmount()
    {
        $orderDetails = new OrderDetails();
        $orderDetails->setFirstAmount(6500);

        $this->assertEquals(6500, $orderDetails->getFirstAmount());
    }
}