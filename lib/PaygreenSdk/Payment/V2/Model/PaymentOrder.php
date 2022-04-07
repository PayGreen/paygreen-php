<?php

namespace Paygreen\Sdk\Payment\V2\Model;

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
    private $type;

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

    /** @var bool */
    private $withPaymentLink = false;

    /** @var null|MultiplePayment */
    private $multiplePayment;

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderInterface $order
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
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     */
    public function setCardToken($cardToken)
    {
        $this->cardToken = $cardToken;
    }

    /**
     * @return bool
     */
    public function getWithPaymentLink()
    {
        return $this->withPaymentLink;
    }

    /**
     * @param bool $withPaymentLink
     */
    public function setWithPaymentLink($withPaymentLink)
    {
        $this->withPaymentLink = $withPaymentLink;
    }

    /**
     * @return null|MultiplePayment
     */
    public function getMultiplePayment()
    {
        return $this->multiplePayment;
    }

    /**
     * @param null|MultiplePayment $multiplePayment
     */
    public function setMultiplePayment($multiplePayment)
    {
        $this->multiplePayment = $multiplePayment;
    }
}
