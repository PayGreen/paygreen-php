<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface OrderInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getReference();

    /**
     * @return BuyerInterface
     */
    public function getBuyer();

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @return int
     */
    public function getAmount();

    /**
     * @return string
     */
    public function getCurrency();
}
