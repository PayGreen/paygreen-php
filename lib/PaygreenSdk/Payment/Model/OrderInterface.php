<?php

namespace Paygreen\Sdk\Payment\Model;

interface OrderInterface
{
    /**
     * @return string
     */
    public function getReference();

    /**
     * @param string $reference
     * @return void
     */
    public function setReference($reference);

    /**
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * @param CustomerInterface $customer
     * @return void
     */
    public function setCustomer($customer);

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @param AddressInterface $shippingAddress
     * @return void
     */
    public function setShippingAddress($shippingAddress);

    /**
     * @return AddressInterface
     */
    public function getBillingAddress();

    /**
     * @param AddressInterface $billingAddress
     * @return void
     */
    public function setBillingAddress($billingAddress);

    /**
     * @return int
     */
    public function getAmount();

    /**
     * @param int $amount
     * @return void
     */
    public function setAmount($amount);
    
    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     * @return void
     */
    public function setCurrency($currency);
}