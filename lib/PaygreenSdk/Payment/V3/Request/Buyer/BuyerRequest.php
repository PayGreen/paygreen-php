<?php

namespace Paygreen\Sdk\Payment\V3\Request\Buyer;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\BuyerInterface;
use Psr\Http\Message\RequestInterface;

class BuyerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param BuyerInterface $buyer
     * @param string|null $shopId
     *
     * @return Request
     */
    public function getGetRequest(BuyerInterface $buyer, $shopId = null)
    {
        $buyerReference = $buyer->getReference();

        return $this->requestFactory->create(
            "/payment/buyers/{$buyerReference}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param BuyerInterface $buyer
     * @param string|null $shopId
     *
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(BuyerInterface $buyer, $shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        $body = [
            'shop_id' => $shopId,
            'email' => $buyer->getEmail(),
            'first_name' => $buyer->getFirstName(),
            'last_name' => $buyer->getLastName(),
            'reference' => $buyer->getReference(),
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
     * @param BuyerInterface $buyer
     *
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(BuyerInterface $buyer)
    {
        $body = [
            'id' => $buyer->getId(),
            'email' => $buyer->getEmail(),
            'first_name' => $buyer->getFirstName(),
            'last_name' => $buyer->getLastName(),
            'reference' => $buyer->getReference(),
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
            "/payment/buyers/{$buyer->getId()}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string|null $shopId
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getListRequest($shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        $body = array(
            'shop_id' => $shopId
        );

        return $this->requestFactory->create(
            "/payment/buyers",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}
