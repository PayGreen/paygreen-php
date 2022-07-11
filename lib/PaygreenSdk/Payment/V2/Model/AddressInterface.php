<?php

namespace Paygreen\Sdk\Payment\V2\Model;

interface AddressInterface
{
    /**
     * @return string
     */
    public function getStreetLineOne();

    /**
     * @return string
     */
    public function getStreetLineTwo();

    /**
     * @return string
     */
    public function getPostcode();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getCountryCode();

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
}
