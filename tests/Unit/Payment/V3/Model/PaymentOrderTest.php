<?php

namespace Paygreen\Tests\Unit\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\PaymentModeEnum;
use Paygreen\Sdk\Payment\V3\Model\Order;
use Paygreen\Sdk\Payment\V3\Model\OrderInterface;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use PHPUnit\Framework\TestCase;

final class PaymentOrderTest extends TestCase
{
    public function testCanGetAndSetPlaforms()
    {
        $paymentOrder = new PaymentOrder();
        $paymentOrder->setPlatforms(['platform-1', 'platform-2']);

        $this->assertEquals(['platform-1', 'platform-2'], $paymentOrder->getPlatforms());
    }

    public function testCanGetAndSetOrder()
    {
        $paymentOrder = new PaymentOrder();
        $order = new Order();
        $paymentOrder->setOrder($order);

        $this->assertInstanceOf(OrderInterface::class, $paymentOrder->getOrder());
        $this->assertEquals($order, $paymentOrder->getOrder());
    }

    public function testCanGetAndSetPaymentMode()
    {
        $paymentOrder = new PaymentOrder();
        $paymentOrder->setPaymentMode(PaymentModeEnum::RECURRING);

        $this->assertEquals(PaymentModeEnum::RECURRING, $paymentOrder->getPaymentMode());
    }

    public function testCanGetAndSetAutoCapture()
    {
        $paymentOrder = new PaymentOrder();
        $paymentOrder->setAutoCapture(true);

        $this->assertEquals(true, $paymentOrder->getAutoCapture());
    }

    public function testCanGetAndSetIntegrationMode()
    {
        $paymentOrder = new PaymentOrder();
        $paymentOrder->setIntegrationMode(IntegrationModeEnum::DIRECT);

        $this->assertEquals(IntegrationModeEnum::DIRECT, $paymentOrder->getIntegrationMode());
    }

    public function testCanGetAndSetPartialAllowed()
    {
        $paymentOrder = new PaymentOrder();
        $paymentOrder->setPartialAllowed(true);

        $this->assertEquals(true, $paymentOrder->isPartialAllowed());
    }
}
