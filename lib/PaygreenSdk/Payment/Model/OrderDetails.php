<?php

namespace Paygreen\Sdk\Payment\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class OrderDetails implements OrderDetailsInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('cycle', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64])
            ])
            ->addPropertyConstraints('count', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64])
            ])
            ->addPropertyConstraints('day', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64])
            ])
            ->addPropertyConstraint('startAt', new Assert\Type('integer'))
            ->addPropertyConstraints('firstAmount', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64])
            ])
        ;
    }

    /** @var int */
    private $cycle;

    /** @var int */
    private $count;

    /** @var int */
    private $day;

    /** @var int */
    private $startAt;

    /** @var int */
    private $firstAmount;

    /**
     * @return int
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param int $cycle
     * @return void
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return void
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $day
     * @return void
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * @param int $startAt
     * @return void
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;
    }

    /**
     * @return int
     */
    public function getFirstAmount()
    {
        return $this->firstAmount;
    }

    /**
     * @param int $firstAmount
     * @return void
     */
    public function setFirstAmount($firstAmount)
    {
        $this->firstAmount = $firstAmount;
    }
}