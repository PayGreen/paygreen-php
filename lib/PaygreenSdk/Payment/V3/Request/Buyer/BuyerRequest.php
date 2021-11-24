<?php

namespace Paygreen\Sdk\Payment\V3\Request\Buyer;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Psr\Http\Message\RequestInterface;

class BuyerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getCreateRequest(Buyer $buyer)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers",
            json_encode([
                'email' => $buyer->getEmail(),
                'first_name' => $buyer->getFirstname(),
                'last_name' => $buyer->getLastname(),
                'reference' => $buyer->getId(),
                'country' => $buyer->getCountryCode()
            ])
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getGetRequest(Buyer $buyer)
    {
        $publicKey = $this->environment->getPublicKey();
        $buyerReference = $buyer->getReference();

        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers/$buyerReference",
            null,
            "GET"            
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(Buyer $buyer)
    {
        $publicKey = $this->environment->getPublicKey();
        $buyerReference = $buyer->getReference();
        
        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers/$buyerReference",
            json_encode([
                'email' => $buyer->getEmail(),
                'first_name' => $buyer->getFirstname(),
                'last_name' => $buyer->getLastname(),
                'reference' => $buyer->getId(),
                'country' => $buyer->getCountryCode(),
            ])
        )->withAuthorization()->isJson()->getRequest();
    }
}