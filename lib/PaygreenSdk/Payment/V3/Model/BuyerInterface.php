<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface BuyerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * Reference to identify the user on the api.
     *
     * @return null|string
     */
    public function getReference();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @return AddressInterface
     */
    public function getBillingAddress();
}
