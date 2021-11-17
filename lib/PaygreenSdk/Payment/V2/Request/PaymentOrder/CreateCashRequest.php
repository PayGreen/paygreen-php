<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class CreateCashRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param PaymentOrder $paymentOrder
     * @return RequestInterface
     */
    public function getRequest(PaymentOrder $paymentOrder)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/$publicKey/payins/transaction/cash",
            $paymentOrder->serialize()
        );
    }
}