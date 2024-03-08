<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentLink;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\PaymentLinkInterface;
use Psr\Http\Message\RequestInterface;

class PaymentLinkRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param int $id
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($id)
    {
        return $this->requestFactory->create(
            '/payment/payment-links/' . urlencode($id),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(PaymentLinkInterface $paymentLink)
    {
        $buyer = null;

        if ($paymentLink->getBuyer()) {
            if (null === $paymentLink->getBuyer()->getId()) {
                $buyer = [
                    'email' => $paymentLink->getBuyer()->getEmail(),
                    'first_name' => $paymentLink->getBuyer()->getFirstName(),
                    'last_name' => $paymentLink->getBuyer()->getLastName(),
                    'reference' => $paymentLink->getBuyer()->getReference(),
                    'phone_number' => $paymentLink->getBuyer()->getPhoneNumber(),
                    'shop_id' => $paymentLink->getShopId(),
                ];
                if (null !== $paymentLink->getBuyer()->getBillingAddress()) {
                    $buyer['billing_address'] = [
                        'city' => $paymentLink->getBuyer()->getBillingAddress()->getCity(),
                        'country' => $paymentLink->getBuyer()->getBillingAddress()->getCountryCode(),
                        'line1' => $paymentLink->getBuyer()->getBillingAddress()->getStreetLineOne(),
                        'line2' => $paymentLink->getBuyer()->getBillingAddress()->getStreetLineTwo(),
                        'postal_code' => $paymentLink->getBuyer()->getBillingAddress()->getPostalCode(),
                        'state' => $paymentLink->getBuyer()->getBillingAddress()->getState(),
                    ];
                }
            } else {
                $buyer = $paymentLink->getBuyer()->getId();
            }
        }

        $body = [
            'amount' => $paymentLink->getAmount(),
            'auto_capture' => $paymentLink->isAutoCapture(),
            'buyer' => $buyer,
            'currency' => $paymentLink->getCurrency(),
            'description' => $paymentLink->getDescription(),
            'platforms' => $paymentLink->getPlatforms(),
            'reference' => $paymentLink->getReference(),
            'shop_id' => $paymentLink->getShopId(),
            'expires_at' => $paymentLink->getExpiresAt()
        ];

        return $this->requestFactory->create(
            '/payment/payment-links',
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
            "/payment/payment-links?" . $this->getListParameters($filters, $pagination),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $id
     *
     * @return Request
     */
    public function getCancelRequest($id)
    {
        return $this->requestFactory->create(
            '/payment/payment-links/' . urlencode($id) . '/cancel'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $id
     *
     * @return Request
     */
    public function getActivateRequest($id)
    {
        return $this->requestFactory->create(
            '/payment/payment-links/' . urlencode($id) . '/activate'
        )->withAuthorization()->isJson()->getRequest();
    }
}
