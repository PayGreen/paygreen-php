<?php

namespace Paygreen\Sdk\Payment\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class OrderDetails implements OrderDetailsInterface
{
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('cycle', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64]),
            ])
            ->addPropertyConstraints('count', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64]),
            ])
            ->addPropertyConstraints('day', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64]),
            ])
            ->addPropertyConstraint('startAt', new Assert\Type('integer'))
            ->addPropertyConstraints('firstAmount', [
                new Assert\Type('integer'),
                new Assert\Length(['min' => 1, 'max' => 64]),
            ])
        ;
    }

    /**
     * @return int
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param int $cycle
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
     */
    public function setFirstAmount($firstAmount)
    {
        $this->firstAmount = $firstAmount;
    }
}
