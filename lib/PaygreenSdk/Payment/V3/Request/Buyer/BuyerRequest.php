<?php

namespace Paygreen\Sdk\Payment\V3\Request\Buyer;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Payment\Model\CustomerInterface;
use Psr\Http\Message\RequestInterface;

class BuyerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getCreateRequest(CustomerInterface $customer)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers",
            json_encode([
                'email' => $customer->getEmail(),
                'first_name' => $customer->getFirstname(),
                'last_name' => $customer->getLastname(),
                'reference' => $customer->getId(),
                'country' => $customer->getCountryCode(),
            ])
        );
    }

    /**
     * @return Request|RequestInterface
     */
    public function getGetRequest(CustomerInterface $customer)
    {
        $publicKey = $this->environment->getPublicKey();
        $buyerReference = $customer->getReference();

        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers/$buyerReference",
            null,
            "GET"            
        );
    }

    /**
     * @return Request|RequestInterface
     */
    public function getUpdateRequest(CustomerInterface $customer)
    {
        $publicKey = $this->environment->getPublicKey();
        $buyerReference = $customer->getReference();
        
        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers/$buyerReference",
            json_encode([
                'email' => $customer->getEmail(),
                'first_name' => $customer->getFirstname(),
                'last_name' => $customer->getLastname(),
                'reference' => $customer->getId(),
                'country' => $customer->getCountryCode(),
            ])
        );
    }
}