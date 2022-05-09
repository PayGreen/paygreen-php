<?php

namespace Paygreen\Sdk\Payment\V3\Request\Buyer;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Psr\Http\Message\RequestInterface;

class BuyerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     * @throws Exception
     */
    public function getCreateRequest(Buyer $buyer)
    {
        $shopId = $this->environment->getShopId();

        $body = [
            'shop_id' => $shopId,
            'email' => $buyer->getEmail(),
            'first_name' => $buyer->getFirstname(),
            'last_name' => $buyer->getLastname(),
            'reference' => $buyer->getId(),
            'country' => $buyer->getCountryCode(),
            'billing_address' => [
                'line1' => $buyer->getBillingAddress()->getStreetLineOne(),
                'line2' => $buyer->getBillingAddress()->getStreetLineTwo(),
                'city' => $buyer->getBillingAddress()->getCity(),
                'postal_code' => $buyer->getBillingAddress()->getPostalCode(),
                'country' => $buyer->getBillingAddress()->getCountryCode(),
            ]
        ];

        return $this->requestFactory->create(
            "/payment/buyers",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getGetRequest(Buyer $buyer)
    {
        $shopId = $this->environment->getShopId();
        $buyerReference = $buyer->getReference();

        return $this->requestFactory->create(
            "/payment/buyers/{$buyerReference}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(Buyer $buyer)
    {
        $buyerReference = $buyer->getReference();

        $body = [
            'email' => $buyer->getEmail(),
            'first_name' => $buyer->getFirstname(),
            'last_name' => $buyer->getLastname(),
            'reference' => $buyer->getId(),
            'country' => $buyer->getCountryCode()
        ];

        if (null !== $buyer->getBillingAddress()) {
            $body [] = [
                'billing_address' => [
                    'line1' => $buyer->getBillingAddress()->getStreetLineOne(),
                    'line2' => $buyer->getBillingAddress()->getStreetLineTwo(),
                    'city' => $buyer->getBillingAddress()->getCity(),
                    'postal_code' => $buyer->getBillingAddress()->getPostalCode(),
                    'country' => $buyer->getBillingAddress()->getCountryCode()
                ]
            ];
        }

        return $this->requestFactory->create(
            "/payment/buyers/{$buyerReference}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
