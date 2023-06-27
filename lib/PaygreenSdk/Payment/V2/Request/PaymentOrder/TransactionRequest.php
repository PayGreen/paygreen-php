<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
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
            '/api/' . urlencode($publicKey) . '/payins/transaction/' . urlencode($transactionId),
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
            '/api/' . urlencode($publicKey) . '/payins/transaction/' . urlencode($transactionId),
            null,
            'PUT'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $transactionId
     * @param int    $amount
     *
     * @return RequestInterface
     */
    public function getUpdateAmountRequest($transactionId, $amount)
    {
        $publicKey = $this->environment->getPublicKey();

        $body = [
            'amount' => $amount,
        ];

        return $this->requestFactory->create(
            '/api/' . urlencode($publicKey) . '/payins/transaction/' . urlencode($transactionId),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'PATCH'
        )->withAuthorization()->isJson()->getRequest();
    }
}
