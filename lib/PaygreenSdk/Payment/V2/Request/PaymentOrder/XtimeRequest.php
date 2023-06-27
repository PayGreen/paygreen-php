<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class XtimeRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws Exception
     *
     * @return RequestInterface
     */
    public function getCreateRequest($paymentOrder)
    {
        $publicKey = $this->environment->getPublicKey();

        $body = [
            'orderId' => $paymentOrder->getOrder()->getReference(),
            'amount' => $paymentOrder->getOrder()->getAmount(),
            'currency' => $paymentOrder->getOrder()->getCurrency(),
            'paymentType' => $paymentOrder->getPaymentType(),
            'type' => $paymentOrder->getType(),
            'notified_url' => $paymentOrder->getNotifiedUrl(),
            'returned_url' => $paymentOrder->getReturnedUrl(),
            'withPaymentLink' => $paymentOrder->getWithPaymentLink(),
            'buyer' => [
                'id' => $paymentOrder->getOrder()->getCustomer()->getId(),
                'lastName' => $paymentOrder->getOrder()->getCustomer()->getLastName(),
                'firstName' => $paymentOrder->getOrder()->getCustomer()->getFirstName(),
                'email' => $paymentOrder->getOrder()->getCustomer()->getEmail(),
                'country' => $paymentOrder->getOrder()->getCustomer()->getCountryCode(),
                'companyName' => $paymentOrder->getOrder()->getCustomer()->getCompanyName(),
            ],
            'shippingAddress' => [
                'lastName' => $paymentOrder->getOrder()->getShippingAddress()->getLastName(),
                'firstName' => $paymentOrder->getOrder()->getShippingAddress()->getFirstName(),
                'address' => $paymentOrder->getOrder()->getShippingAddress()->getStreet(),
                'zipCode' => $paymentOrder->getOrder()->getShippingAddress()->getPostcode(),
                'city' => $paymentOrder->getOrder()->getShippingAddress()->getCity(),
                'country' => $paymentOrder->getOrder()->getShippingAddress()->getCountryCode(),
            ],
            'billingAddress' => [
                'lastName' => $paymentOrder->getOrder()->getBillingAddress()->getLastName(),
                'firstName' => $paymentOrder->getOrder()->getBillingAddress()->getFirstName(),
                'address' => $paymentOrder->getOrder()->getBillingAddress()->getStreet(),
                'zipCode' => $paymentOrder->getOrder()->getBillingAddress()->getPostcode(),
                'city' => $paymentOrder->getOrder()->getBillingAddress()->getCity(),
                'country' => $paymentOrder->getOrder()->getBillingAddress()->getCountryCode(),
            ],
            'metadata' => $paymentOrder->getMetadata(),
            'ttl' => $paymentOrder->getTtl(),
        ];

        if (!empty($paymentOrder->getCardToken())) {
            $body['card'] = [
                'token' => $paymentOrder->getCardToken(),
            ];
        }

        if (!empty($paymentOrder->getMultiplePayment())) {
            $body['orderDetails'] = [
                'cycle' => $paymentOrder->getMultiplePayment()->getCycle(),
                'count' => $paymentOrder->getMultiplePayment()->getCount(),
                'firstAmount' => $paymentOrder->getMultiplePayment()->getFirstAmount(),
                'day' => $paymentOrder->getMultiplePayment()->getDay(),
                'startAt' => $paymentOrder->getMultiplePayment()->getStartAt(),
            ];
        }

        $body['eligibleAmount'][$paymentOrder->getPaymentType()] = $body['amount'];

        return $this->requestFactory->create(
            '/api/' . urlencode($publicKey) . '/payins/transaction/xtime',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
