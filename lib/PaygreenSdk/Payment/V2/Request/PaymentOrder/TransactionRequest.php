<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Psr\Http\Message\RequestInterface;

class TransactionRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $transactionId
     *
     * @return RequestInterface
     */
    public function getGetRequest($transactionId)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/$transactionId",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $transactionId
     *
     * @return RequestInterface
     */
    public function getConfirmationRequest($transactionId)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/$transactionId",
            null,
            'PUT'
        )->withAuthorization()->isJson()->getRequest();
    }
}