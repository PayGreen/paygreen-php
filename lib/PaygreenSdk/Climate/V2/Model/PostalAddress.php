<?php

namespace Paygreen\Sdk\Climate\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class PostalAddress
{
    /** @var string */
    public $address;

    /** @var string */
    public $zipCode;

    /** @var string */
    public $city;

    /** @var string */
    public $country;
    
    public function __construct($address, $zipCode, $city, $country)
    {
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->country = $country;
    }

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
}