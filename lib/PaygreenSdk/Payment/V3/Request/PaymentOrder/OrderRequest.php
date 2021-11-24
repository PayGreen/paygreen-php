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

        return $this->requestFactory->create(
            '/payment/payment-orders',
            json_encode([
                'amount' => $paymentOrder->getOrder()->getAmount(),
                'currency' => $paymentOrder->getOrder()->getCurrency(),
                'paymentMode' => $paymentOrder->getPaymentMode(),
                'reference' => $paymentOrder->getOrder()->getReference(),
                'auto_capture' => $paymentOrder->getAutoCapture(),
                'integration_mode' => $paymentOrder->getIntegrationMode(),
                'partial_allowed' => $paymentOrder->isPartialAllowed(),
                'platforms' => $paymentOrder->getPlatforms(),
                'buyer' => $buyer,
            ])
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

        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentId}",
            json_encode([
                'partial_allowed' => $paymentOrder->isPartialAllowed(),
            ])
        )->withAuthorization()->isJson()->getRequest();
    }
}
