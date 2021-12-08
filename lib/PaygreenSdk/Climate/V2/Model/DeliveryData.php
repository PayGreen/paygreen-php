<?php

namespace Paygreen\Sdk\Climate\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DeliveryData
{
    /** @var float */
    private $totalWeightInKg;
    
    /** @var PostalAddress */
    private $departure;

    /** @var PostalAddress */
    private $arrival;

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
            ->addPropertyConstraints('departure', [
                new Assert\NotBlank(),
                new Assert\Type(PostalAddress::class),
                new Assert\Valid()
            ])
            ->addPropertyConstraints('arrival', [
                new Assert\NotBlank(),
                new Assert\Type(PostalAddress::class),
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
     * @return PostalAddress
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param PostalAddress $departure
     */
    public function setDeparture(PostalAddress $departure)
    {
        $this->departure = $departure;
    }

    /**
     * @return PostalAddress
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param PostalAddress $arrival
     */
    public function setArrival(PostalAddress $arrival)
    {
        $this->arrival = $arrival;
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