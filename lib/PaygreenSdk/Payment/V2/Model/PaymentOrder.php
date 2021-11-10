<?php

namespace Paygreen\Sdk\Payment\V2\Model;

use Paygreen\Sdk\Payment\Model\OrderInterface;
use stdClass;

class PaymentOrder
{
    /** 
     * @var OrderInterface 
     */
    private $order;

    /**
     * @var string
     */
    private $paymentType;

    /**
     * @var string
     */
    private $notifiedUrl;

    /**
     * @var string
     */
    private $returnedUrl;

    /**
     * @var array<string>
     */
    private $metadata;

    /**
     * @var array<string>
     */
    private $eligibleAmount;

    /**
     * @var string
     */
    private $ttl;

    /**
     * @var string
     */
    private $cardToken;
    
    /**
     * @return array<string|array<string>|int|stdClass|string>.
     */
    public function serialize() {
        $order = $this->getOrder();
        
        $serialized = [
            'orderId' => $order->getReference(),
            'amount' => $order->getAmount(),
            'currency' => $order->getCurrency(),
            'paymentType' => $this->getPaymentType(),
            'notifiedUrl' => $this->getNotifiedUrl(),
            'returnedUrl' => $this->getReturnedUrl(),
            'buyer' => (object) [
                'id' => $order->getCustomer()->getId(),
                'lastName' => $order->getCustomer()->getLastName(),
                'firstName' => $order->getCustomer()->getFirstName(),
                'email' => $order->getCustomer()->getEmail(),
                'country' => $order->getCustomer()->getCountryCode(),
                'companyName' => $order->getCustomer()->getCompanyName()
            ],
            'shippingAddress' => (object) [
                'lastName' => $order->getShippingAddress()->getLastName(),
                'firstName' => $order->getShippingAddress()->getFirstName(),
                'address' => $order->getShippingAddress()->getStreet(),
                'zipCode' => $order->getShippingAddress()->getPostcode(),
                'city' => $order->getShippingAddress()->getCity(),
                'country' => $order->getShippingAddress()->getCountryCode()
            ],
            'billingAddress' => (object) [
                'lastName' => $order->getBillingAddress()->getLastName(),
                'firstName' => $order->getBillingAddress()->getFirstName(),
                'address' => $order->getBillingAddress()->getStreet(),
                'zipCode' => $order->getBillingAddress()->getPostcode(),
                'city' => $order->getBillingAddress()->getCity(),
                'country' => $order->getBillingAddress()->getCountryCode()
            ],
            'metadata' => $this->getMetadata(),
            'eligibleAmount' => $this->getEligibleAmount(),
            'ttl' => $this->getTtl()
        ];

        if (!empty($this->getCardToken())) {
            $serialized['card'] = (object) [
                'token' => $this->getCardToken()
            ];
        }
        
        return $serialized;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return void
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return string
     */
    public function getNotifiedUrl()
    {
        return $this->notifiedUrl;
    }

    /**
     * @param string $notifiedUrl
     * @return void
     */
    public function setNotifiedUrl($notifiedUrl)
    {
        $this->notifiedUrl = $notifiedUrl;
    }

    /**
     * @return string
     */
    public function getReturnedUrl()
    {
        return $this->returnedUrl;
    }

    /**
     * @param string $returnedUrl
     * @return void
     */
    public function setReturnedUrl($returnedUrl)
    {
        $this->returnedUrl = $returnedUrl;
    }

    /**
     * @return array<string>
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array<string> $metadata
     * @return void
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return array<string>
     */
    public function getEligibleAmount()
    {
        return $this->eligibleAmount;
    }

    /**
     * @param array<string> $eligibleAmount
     * @return void
     */
    public function setEligibleAmount($eligibleAmount)
    {
        $this->eligibleAmount = $eligibleAmount;
    }

    /**
     * @return string
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param string $ttl
     * @return void
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * @return string
     */
    public function getCardToken()
    {
        return $this->cardToken;
    }

    /**
     * @param string $cardToken
     * @return void
     */
    public function setCardToken($cardToken)
    {
        $this->cardToken = $cardToken;
    }
}
 