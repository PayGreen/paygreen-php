<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

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
    private $streetLineTwo;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('postcode', new Assert\NotBlank())
            ->addPropertyConstraints('city', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraints('countryCode', [
                new Assert\Type('string'),
            ])
            ->addPropertyConstraints('streetLineOne', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraint('streetLineTwo', new Assert\Type('string'))
        ;
    }

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
