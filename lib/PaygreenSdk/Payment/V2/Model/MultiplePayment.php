<?php

namespace Paygreen\Sdk\Payment\V2\Model;

use Paygreen\Sdk\Payment\Model\OrderDetailsInterface;

class MultiplePayment
{
    /** @var bool */
    private $withPaymentLink = false;

    /** @var OrderDetailsInterface */
    private $orderDetails;

    /**
     * @return bool
     */
    public function getWithPaymentLink()
    {
        return $this->withPaymentLink;
    }

    /**
     * @param bool $withPaymentLink
     * @return void
     */
    public function setWithPaymentLink($withPaymentLink)
    {
        $this->withPaymentLink = $withPaymentLink;
    }

    /**
     * @return OrderDetailsInterface
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    /**
     * @param OrderDetailsInterface $orderDetails
     * @return void
     */
    public function setOrderDetails(OrderDetailsInterface $orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }
}