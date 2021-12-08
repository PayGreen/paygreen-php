<?php

namespace Paygreen\Sdk\Climate\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DeliveryData
{
    /** @var float */
    private $totalWeightInKg;
    
    /** @var Address */
    private $shippedFrom;

    /** @var Address */
    private $shippedTo;

    /** @var string */
    private $transportationExternalId;
    
    /** @var string */
    private $deliveryService;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('totalWeightInKg', [
                new Assert\NotBlank(),
                new Assert\Type('float'),
            ])
            ->addPropertyConstraints('shippedFrom', [
                new Assert\NotBlank(),
                new Assert\Type(Address::class),
                new Assert\Valid()
            ])
            ->addPropertyConstraints('shippedTo', [
                new Assert\NotBlank(),
                new Assert\Type(Address::class),
                new Assert\Valid()
            ])
            ->addPropertyConstraints('transportationExternalId', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
            ->addPropertyConstraint('deliveryService', new Assert\Type('string'))
        ;
    }

    /**
     * @return float
     */
    public function getTotalWeightInKg()
    {
        return $this->totalWeightInKg;
    }

    /**
     * @param float $totalWeightInKg
     */
    public function setTotalWeightInKg($totalWeightInKg)
    {
        $this->totalWeightInKg = $totalWeightInKg;
    }

    /**
     * @return Address
     */
    public function getShippedFrom()
    {
        return $this->shippedFrom;
    }

    /**
     * @param Address $shippedFrom
     */
    public function setShippedFrom($shippedFrom)
    {
        $this->shippedFrom = $shippedFrom;
    }

    /**
     * @return Address
     */
    public function getShippedTo()
    {
        return $this->shippedTo;
    }

    /**
     * @param Address $shippedTo
     */
    public function setShippedTo($shippedTo)
    {
        $this->shippedTo = $shippedTo;
    }

    /**
     * @return string
     */
    public function getTransportationExternalId()
    {
        return $this->transportationExternalId;
    }

    /**
     * @param string $transportationExternalId
     */
    public function setTransportationExternalId($transportationExternalId)
    {
        $this->transportationExternalId = $transportationExternalId;
    }

    /**
     * @return string
     */
    public function getDeliveryService()
    {
        return $this->deliveryService;
    }

    /**
     * @param string $deliveryService
     */
    public function setDeliveryService($deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }
}