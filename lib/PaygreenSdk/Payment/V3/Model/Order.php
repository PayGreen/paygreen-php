<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class Order implements OrderInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var BuyerInterface
     */
    private $buyer;

    /**
     * @var AddressInterface
     */
    private $shippingAddress;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return BuyerInterface
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * @param BuyerInterface $buyer
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * @return AddressInterface
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param AddressInterface $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
