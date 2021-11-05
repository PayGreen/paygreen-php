<?php

namespace Paygreen\Sdk\Payment\Model;

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