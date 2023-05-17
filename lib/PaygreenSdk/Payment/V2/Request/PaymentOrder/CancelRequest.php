<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class CancelRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $transactionId
     *
     * @throws Exception
     *
     * @return RequestInterface
     */
    public function getCancelRequest($transactionId)
    {
        $publicKey = $this->environment->getPublicKey();

        $body = [
            'id' => $transactionId,
        ];

        return $this->requestFactory->create(
            '/api/' . urlencode($publicKey) . '/payins/transaction/cancel',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
