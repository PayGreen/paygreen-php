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
            json_encode([
                'amount' => $paymentOrder->getOrder()->getAmount(),
                'currency' => $paymentOrder->getOrder()->getCurrency(),
                'paymentMode' => $paymentOrder->getPaymentMode(),
                'reference' => $paymentOrder->getOrder()->getReference(),
                'auto_capture' => $paymentOrder->getAutoCapture(),
                'integration_mode' => $paymentOrder->getIntegrationMode(),
                'buyer' => [
                    'email' => $paymentOrder->getOrder()->getCustomer()->getEmail(),
                    'firstName' => $paymentOrder->getOrder()->getCustomer()->getFirstName(),
                    'lastName' => $paymentOrder->getOrder()->getCustomer()->getLastName(),
                    'reference' => $paymentOrder->getOrder()->getCustomer()->getId(),
                    'country' => $paymentOrder->getOrder()->getCustomer()->getCountryCode()
                ]
            ])
        );
    }

}