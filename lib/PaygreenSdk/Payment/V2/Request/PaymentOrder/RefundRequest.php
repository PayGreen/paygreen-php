<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class RefundRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string   $transactionId
     * @param null|int $amount
     *
     * @return RequestInterface
     */
    public function getCreateRequest($transactionId, $amount = null)
    {
        $publicKey = $this->environment->getPublicKey();

        if (!is_null($amount)) {
            $body = [
                'amount' => $amount,
            ];
        } else {
            $body = array();
        }

        return $this->requestFactory->create(
            '/api/' . urlencode($publicKey) . '/payins/transaction/' . urlencode($transactionId),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }
}
