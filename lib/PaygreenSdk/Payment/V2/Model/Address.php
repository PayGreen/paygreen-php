<?php

namespace Paygreen\Sdk\Payment\V2\Model;

class Address implements AddressInterface
{
    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $streetLineOne;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $streetLineTwo;

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getStreetLineOne()
    {
        return $this->streetLineOne;
    }

    /**
     * @param string $streetLineOne
     */
    public function setStreetLineOne($streetLineOne)
    {
        $this->streetLineOne = $streetLineOne;
    }

    /**
     * @return string
     */
    public function getStreetLineTwo()
    {
        return $this->streetLineTwo;
    }

    /**
     * @param string $streetLineTwo
     */
    public function setStreetLineTwo($streetLineTwo)
    {
        $this->streetLineTwo = $streetLineTwo;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        if (!empty($this->getStreetLineTwo())) {
            $street = implode(' ', [
                $this->getStreetLineOne(),
                $this->getStreetLineTwo(),
            ]);
        } else {
            $street = $this->getStreetLineOne();
        }

        return $street;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }
}
