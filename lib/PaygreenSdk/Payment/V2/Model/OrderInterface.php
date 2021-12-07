<?php

namespace Paygreen\Sdk\Payment\V2\Model;

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

    /**
     * @return int
     */
    public function getAmount();
    
    /**
     * @return string
     */
    public function getCurrency();
}
