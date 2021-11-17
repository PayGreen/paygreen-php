<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Psr\Http\Message\RequestInterface;

class CancelRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $transactionId
     * @return RequestInterface
     */
    public function getCancelRequest($transactionId)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/$publicKey/payins/transaction/cancel",
            [
                'id' => $transactionId
            ]
        );
    }
}