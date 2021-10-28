<?php

namespace Paygreen\Sdk\Payments\Interfaces;

interface AddressInterface
{
    /**
     * @return string
     */
    public function getAddressLineOne();

    /**
     * @return string
     */
    public function getAddressLineTwo();

    /**
     * @return string
     */
    public function getStreet();

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
    public function getZipCode();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getCountryCode();
}
