<?php

namespace Paygreen\Sdk\Payment\V3\Request\Buyer;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\AddressInterface;
use Paygreen\Sdk\Payment\V3\Model\BuyerInterface;
use Psr\Http\Message\RequestInterface;

class BuyerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $buyerId
     *
     * @return Request
     */
    public function getGetRequest($buyerId)
    {
        return $this->requestFactory->create(
            '/payment/buyers/' . urlencode($buyerId),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param $filters
     * @param $pagination
     * @return RequestInterface
     */
    public function getListRequest($filters = [], $pagination = [])
    {
        return $this->requestFactory->create(
            "/payment/buyers?" . $this->getListParameters($filters, $pagination),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param BuyerInterface $buyer
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     * @throws Exception
     *
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
            'phone_number' => $buyer->getPhoneNumber(),
            'billing_address' => $this->handleBillingAddress($buyer->getBillingAddress())
        ];

        return $this->requestFactory->create(
            '/payment/buyers',
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
            'phone_number' => $buyer->getPhoneNumber(),
            'billing_address' => $this->handleBillingAddress($buyer->getBillingAddress())
        ];

        return $this->requestFactory->create(
            '/payment/buyers/' . urlencode($buyer->getId()),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param AddressInterface|null $billingAddress
     * @return array|null
     */
    private function handleBillingAddress($billingAddress)
    {
        if (null !== $billingAddress) {
            $billingAddress =  [
                'line1' => $billingAddress->getStreetLineOne(),
                'line2' => $billingAddress->getStreetLineTwo(),
                'city' => $billingAddress->getCity(),
                'postal_code' => $billingAddress->getPostalCode(),
                'country' => $billingAddress->getCountryCode(),
                'state' => $billingAddress->getState(),
            ];
        }

        return $billingAddress;
    }
}
