<?php

namespace Paygreen\Sdk\Payment\V3\Request\Transfer;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\PaymentConfigInterface;
use Psr\Http\Message\RequestInterface;

class TransferRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param int $amount
     * @param PaymentConfigInterface|null $paymentConfigSource
     * @param PaymentConfigInterface|null $paymentConfigDestination
     *
     * @return Request|RequestInterface
     * @throws Exception
     */
    public function getCreateRequest($amount, PaymentConfigInterface $paymentConfigSource = null, PaymentConfigInterface $paymentConfigDestination = null)
    {
        $body = [
            'amount' => $amount,
        ];

        if ($paymentConfigSource) {
            $body['source'] = $paymentConfigSource->getId();
        }

        if ($paymentConfigDestination) {
            $body['destination'] = $paymentConfigDestination->getId();
        }

        return $this->requestFactory->create(
            '/payment/transfers',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
