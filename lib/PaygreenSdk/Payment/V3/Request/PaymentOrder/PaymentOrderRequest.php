<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentOrder;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class PaymentOrderRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param int $paymentOrderId
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($paymentOrderId)
    {
        return $this->requestFactory->create(
            '/payment/payment-orders/' . urlencode($paymentOrderId),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(PaymentOrder $paymentOrder)
    {
        $buyer = null;

        if ($paymentOrder->getBuyer()) {
            if (null === $paymentOrder->getBuyer()->getId()) {
                $buyer = [
                    'email' => $paymentOrder->getBuyer()->getEmail(),
                    'first_name' => $paymentOrder->getBuyer()->getFirstName(),
                    'last_name' => $paymentOrder->getBuyer()->getLastName(),
                    'reference' => $paymentOrder->getBuyer()->getReference(),
                    'phone_number' => $paymentOrder->getBuyer()->getPhoneNumber(),
                    'shop_id' => $paymentOrder->getShopId(),
                ];
                if (null !== $paymentOrder->getBuyer()->getBillingAddress()) {
                    $buyer['billing_address'] = [
                        'city' => $paymentOrder->getBuyer()->getBillingAddress()->getCity(),
                        'country' => $paymentOrder->getBuyer()->getBillingAddress()->getCountryCode(),
                        'line1' => $paymentOrder->getBuyer()->getBillingAddress()->getStreetLineOne(),
                        'line2' => $paymentOrder->getBuyer()->getBillingAddress()->getStreetLineTwo(),
                        'postal_code' => $paymentOrder->getBuyer()->getBillingAddress()->getPostalCode(),
                        'state' => $paymentOrder->getBuyer()->getBillingAddress()->getState(),
                    ];
                }
            } else {
                $buyer = $paymentOrder->getBuyer()->getId();
            }
        }

        $body = [
            'amount' => $paymentOrder->getAmount(),
            'eligible_amounts' => $paymentOrder->getEligibleAmounts(),
            'auto_capture' => $paymentOrder->isAutoCapture(),
            'buyer' => $buyer,
            'capture_on' => $paymentOrder->getCaptureOn(),
            'cancel_url' => $paymentOrder->getCancelUrl(),
            'currency' => $paymentOrder->getCurrency(),
            'description' => $paymentOrder->getDescription(),
            'instrument' => $paymentOrder->getInstrument(),
            'max_operations' => $paymentOrder->getMaxOperations(),
            'merchant_initiated' => $paymentOrder->isMerchantInitiated(),
            'partial_allowed' => $paymentOrder->isPartialAllowed(),
            'platforms' => $paymentOrder->getPlatforms(),
            'reference' => $paymentOrder->getReference(),
            'return_url' => $paymentOrder->getReturnUrl(),
            'shop_id' => $paymentOrder->getShopId(),
            'metadata' => $paymentOrder->getMetadata(),
            'fees' => $paymentOrder->getFees()
        ];

        if (null !== $paymentOrder->getShippingAddress()) {
            $body['shipping_address'] = [
                'city' => $paymentOrder->getShippingAddress()->getCity(),
                'country' => $paymentOrder->getShippingAddress()->getCountryCode(),
                'line1' => $paymentOrder->getShippingAddress()->getStreetLineOne(),
                'line2' => $paymentOrder->getShippingAddress()->getStreetLineTwo(),
                'postal_code' => $paymentOrder->getShippingAddress()->getPostalCode(),
                'state' => $paymentOrder->getShippingAddress()->getState(),
            ];
        }

        return $this->requestFactory->create(
            '/payment/payment-orders',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(PaymentOrder $paymentOrder)
    {
        $body = ['partial_allowed' => $paymentOrder->isPartialAllowed()];

        return $this->requestFactory->create(
            '/payment/payment-orders/' . urlencode($paymentOrder->getId()),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param int $paymentOrderId
     *
     * @return Request|RequestInterface
     */
    public function getCaptureRequest($paymentOrderId)
    {
        return $this->requestFactory->create(
            '/payment/payment-orders/' . urlencode($paymentOrderId) . '/capture'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $paymentOrderId
     * @param ?string $operationId
     * @param ?int $amount
     *
     * @return Request|RequestInterface
     */
    public function getRefundRequest($paymentOrderId, $operationId = null, $amount = null)
    {
        $body = [
            'operation_id' => $operationId,
            'amount' => $amount
        ];

        return $this->requestFactory->create(
            '/payment/payment-orders/' . urlencode($paymentOrderId) . '/refund',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param $filters
     * @param $pagination
     *
     * @return RequestInterface
     * @throws Exception
     */
    public function getListRequest($filters = [], $pagination = [])
    {
        return $this->requestFactory->create(
            "/payment/payment-orders?" . $this->getListParameters($filters, $pagination),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $paymentOrderId
     *
     * @return Request
     */
    public function getCancelRequest($paymentOrderId)
    {
        return $this->requestFactory->create(
            '/payment/payment-orders/' . urlencode($paymentOrderId) . '/cancel'
        )->withAuthorization()->isJson()->getRequest();
    }
}
