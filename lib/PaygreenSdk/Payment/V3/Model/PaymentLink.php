<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class PaymentLink
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
     * @var int
     */
    private $amount;

    /**
     * @var bool
     */
    private $autoCapture;

    /**
     * @var BuyerInterface
     */
    private $buyer;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $platforms;

    /**
     * @var string
     */
    private $shopId;

    /**
     * @var string
     */
    private $expiresAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Your reference to this Payment Order
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * The amount (in cts)
     *
     * @param int $amount
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoCapture()
    {
        return $this->autoCapture;
    }

    /**
     * If true, the operations will be automatically captured whenever possible.
     * Otherwise, you need to call the Capture endpoint. Default is true.
     *
     * @param bool $autoCapture
     * @return self
     */
    public function setAutoCapture($autoCapture)
    {
        $this->autoCapture = $autoCapture;

        return $this;
    }

    /**
     * @return BuyerInterface
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Existing Buyer ID, or new Buyer entity
     *
     * @param BuyerInterface $buyer
     * @return self
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;

        return $this;
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
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * An optional description to this Payment Order
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * An array containing the platforms that can be processed through this Payment Order.
     * If not set, all the validated Platforms of your Shop will be available.
     *
     * @param array $platforms
     * @return self
     */
    public function setPlatforms($platforms)
    {
        $this->platforms = $platforms;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * The beneficiary Shop ID. If you are a Marketplace, set the sub-entity ID here.
     *
     * @param string $shopId
     * @return self
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param string $expiresAt
     * @return self
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
