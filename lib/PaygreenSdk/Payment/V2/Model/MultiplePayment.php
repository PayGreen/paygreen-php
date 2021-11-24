<?php

namespace Paygreen\Sdk\Payment\V2\Model;

use Paygreen\Sdk\Payment\Model\OrderDetailsInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class MultiplePayment
{
    /**
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('orderDetails', [
                new Assert\NotBlank(),
                new Assert\Type(OrderDetailsInterface::class),
                new Assert\Valid()
            ])
        ;
    }

    /** @var OrderDetailsInterface */
    private $orderDetails;

    /**
     * @return OrderDetailsInterface
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    /**
     * @param OrderDetailsInterface $orderDetails
     * @return void
     */
    public function setOrderDetails(OrderDetailsInterface $orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }
}