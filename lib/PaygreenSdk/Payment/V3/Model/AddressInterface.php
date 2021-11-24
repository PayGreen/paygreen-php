<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface AddressInterface
{
    /**
     * @return string
     */
    public function getStreetLineOne();

    /**
     * @param string $streetLineOne
     * @return void
     */
    public function setStreetLineOne($streetLineOne);

    /**
     * @return string
     */
    public function getStreetLineTwo();

    /**
     * @param string $streetLineTwo
     * @return void
     */
    public function setStreetLineTwo($streetLineTwo);

    /**
     * @return string
     */
    public function getPostcode();

    /**
     * @param string $postcode
     * @return void
     */
    public function setPostcode($postcode);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     * @return void
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getCountryCode();

    /**
     * @param string $countryCode
     * @return void
     */
    public function setCountryCode($countryCode);

    /**
     * @return string
     */
    public function getStreet();
}
