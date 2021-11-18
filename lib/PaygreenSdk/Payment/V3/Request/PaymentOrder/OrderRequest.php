<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentOrder;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class OrderRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getCreateRequest(PaymentOrder $paymentOrder)
    {
        return $this->requestFactory->create(
            "/payment/payment-orders",
            $paymentOrder->serialize()
        );
    }

}