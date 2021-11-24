<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentOrder;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class OrderRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getCreateRequest(PaymentOrder $paymentOrder)
    {
        if (null === $paymentOrder->getOrder()->getBuyer()->getReference()) {
            $buyer = [
                'email' => $paymentOrder->getOrder()->getBuyer()->getEmail(),
                'firstName' => $paymentOrder->getOrder()->getBuyer()->getFirstName(),
                'lastName' => $paymentOrder->getOrder()->getBuyer()->getLastName(),
                'reference' => $paymentOrder->getOrder()->getBuyer()->getId(),
                'country' => $paymentOrder->getOrder()->getBuyer()->getCountryCode(),
            ];
        } else {
            $buyer = $paymentOrder->getOrder()->getBuyer()->getReference();
        }

        $body = [
            'amount' => $paymentOrder->getOrder()->getAmount(),
            'currency' => $paymentOrder->getOrder()->getCurrency(),
            'paymentMode' => $paymentOrder->getPaymentMode(),
            'reference' => $paymentOrder->getOrder()->getReference(),
            'auto_capture' => $paymentOrder->getAutoCapture(),
            'integration_mode' => $paymentOrder->getIntegrationMode(),
            'partial_allowed' => $paymentOrder->isPartialAllowed(),
            'platforms' => $paymentOrder->getPlatforms(),
            'buyer' => $buyer,
        ];

        return $this->requestFactory->create(
            '/payment/payment-orders',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getGetRequest(PaymentOrder $paymentOrder)
    {
        $paymentId = $paymentOrder->getOrder()->getReference();

        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(PaymentOrder $paymentOrder)
    {
        $paymentId = $paymentOrder->getOrder()->getReference();

        $body = ['partial_allowed' => $paymentOrder->isPartialAllowed()];

        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentId}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
