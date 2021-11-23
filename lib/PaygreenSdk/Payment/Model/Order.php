<?php

namespace Paygreen\Sdk\Payment\Model;

class Order implements OrderInterface
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var AddressInterface
     */
    private $shippingAddress;

    /**
     * @var AddressInterface
     */
    private $billingAddress;

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
     * @return void
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface $customer
     * @return void
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
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
     * @return void
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return AddressInterface
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param AddressInterface $billingAddress
     * @return void
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
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
     * @return void
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
     * @return void
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
}