<?php

namespace Paygreen\Sdk\Payment\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class MultiplePayment
{
    /** @var OrderDetailsInterface */
    private $orderDetails;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('orderDetails', [
                new Assert\NotBlank(),
                new Assert\Type(OrderDetailsInterface::class),
                new Assert\Valid(),
            ])
        ;
    }

    /**
     * @return OrderDetailsInterface
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(OrderDetailsInterface $orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }
}
