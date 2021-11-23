<?php

namespace Paygreen\Sdk\Payment\V2\Model;

use Paygreen\Sdk\Payment\Model\OrderDetailsInterface;

class MultiplePayment
{
    /** @var OrderDetailsInterface */
    private $orderDetails;

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