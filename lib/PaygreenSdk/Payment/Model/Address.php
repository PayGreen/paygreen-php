<?php

namespace Paygreen\Sdk\Payment\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Address implements AddressInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('postcode', new Assert\NotBlank())
            ->addPropertyConstraints('city', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraints('countryCode', [
                new Assert\Type('string')
            ])
            ->addPropertyConstraints('streetLineOne', [
                    new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraint('streetLineTwo', new Assert\Type('string'))
        ;
    }

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

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     * @return void
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
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return void
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return void
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
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
     * @return void
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
     * @return void
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
     * @return void
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

}