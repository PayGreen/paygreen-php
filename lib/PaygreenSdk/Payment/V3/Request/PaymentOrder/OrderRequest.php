<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentOrder;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class OrderRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(PaymentOrder $paymentOrder)
    {
        if (null === $paymentOrder->getOrder()->getBuyer()->getReference()) {
            $buyer = [
                'email' => $paymentOrder->getOrder()->getBuyer()->getEmail(),
                'first_name' => $paymentOrder->getOrder()->getBuyer()->getFirstName(),
                'last_name' => $paymentOrder->getOrder()->getBuyer()->getLastName(),
                'reference' => $paymentOrder->getOrder()->getBuyer()->getId(),
                'country' => $paymentOrder->getOrder()->getBuyer()->getCountryCode(),
            ];
        } else {
            $buyer = $paymentOrder->getOrder()->getBuyer()->getReference();
        }

        $body = [
            'amount' => $paymentOrder->getOrder()->getAmount(),
            'auto_capture' => $paymentOrder->getAutoCapture(),
            'buyer' => $buyer,
            'cancel_url' => $paymentOrder->getCancelUrl(),
            'currency' => $paymentOrder->getOrder()->getCurrency(),
            'cycle' => $paymentOrder->getCycle(),
            'description' => $paymentOrder->getDescription(),
            'eligible_amounts' => $paymentOrder->getEligibleAmount(),
            'first_amount' => $paymentOrder->getFirstAmount(),
            'instrument' => $paymentOrder->getInstrumentId(),
            'integration_mode' => $paymentOrder->getIntegrationMode(),
            'is_merchant_initiated' => $paymentOrder->isMerchantInitiated(),
            'mode' => $paymentOrder->getPaymentMode(),
            'notification_url' => $paymentOrder->getNotificationUrl(),
            'occurences' => $paymentOrder->getOccurences(),
            'partial_allowed' => $paymentOrder->isPartialAllowed(),
            'platforms' => $paymentOrder->getPlatforms(),
            'previous_order_id' => $paymentOrder->getPreviousOrderId(),
            'reference' => $paymentOrder->getOrder()->getReference(),
            'return_url' => $paymentOrder->getReturnUrl(),
            'shop_id' => $paymentOrder->getPlatformsShopId(),
            'start_at' => $paymentOrder->getStartAt(),
            'ttl' => $paymentOrder->getInstrumentTTL(),
        ];

        return $this->requestFactory->create(
            '/payment/payment-orders',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param int $paymentReference
     * 
     * @return Request|RequestInterface
     */
    public function getGetRequest($paymentReference)
    {
        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentReference}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(PaymentOrder $paymentOrder)
    {
        $paymentReference = $paymentOrder->getOrder()->getReference();
        $body = ['partial_allowed' => $paymentOrder->isPartialAllowed()];

        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentReference}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param int $paymentReference
     * 
     * @return Request|RequestInterface
     */
    public function getCaptureRequest($paymentReference)
    {
        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentReference}/capture"
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param int $paymentReference
     * 
     * @return Request|RequestInterface
     */
    public function getRefundRequest($paymentReference)
    {
        return $this->requestFactory->create(
            "/payment/payment-orders/{$paymentReference}/refund"
        )->withAuthorization()->isJson()->getRequest();
    }
}
