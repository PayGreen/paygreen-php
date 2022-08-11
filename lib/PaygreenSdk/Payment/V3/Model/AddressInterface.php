<?php

namespace Paygreen\Sdk\Payment\V3\Model;

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
    public function getPostalCode();

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
    public function getState();
}
