<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Order implements OrderInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var BuyerInterface
     */
    private $buyer;

    /**
     * @var AddressInterface
     */
    private $shippingAddress;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('reference', new Assert\NotBlank(["groups"=>["reference"]]))
            ->addPropertyConstraints('buyer', [
                new Assert\NotBlank(),
                new Assert\Type(BuyerInterface::class),
                new Assert\Valid(),
            ])
            ->addPropertyConstraints('shippingAddress', [
                new Assert\NotBlank(),
                new Assert\Type(AddressInterface::class),
                new Assert\Valid(),
            ])
            ->addPropertyConstraints('amount', [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
            ])
            ->addPropertyConstraints('currency', [
                new Assert\NotBlank(),
                new Assert\Type('string'),
            ])
        ;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return BuyerInterface
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * @param BuyerInterface $buyer
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * @return AddressInterface
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param AddressInterface $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
