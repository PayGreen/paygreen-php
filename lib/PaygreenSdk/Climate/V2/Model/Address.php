<?php

namespace Paygreen\Sdk\Climate\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Address
{
    /** @var string */
    private $address;

    /** @var string */
    private $zipCode;

    /** @var string */
    private $city;

    /** @var string */
    private $country;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('address', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraints('zipCode', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraints('city', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraints('country', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
        ;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}