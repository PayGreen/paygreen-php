<?php

namespace Paygreen\Sdk\Payments\Interfaces;

interface OrderInterface
{
    /**
     * @return string
     */
    public function getReference();

    /**
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @return AddressInterface
     */
    public function getBillingAddress();
}