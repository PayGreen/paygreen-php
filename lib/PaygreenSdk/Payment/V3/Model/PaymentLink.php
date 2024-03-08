<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class PaymentLink implements PaymentLinkInterface
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
     * @var array
     */
    private $eligibleAmounts;

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
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
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
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
     */
    public function setAutoCapture($autoCapture)
    {
        $this->autoCapture = $autoCapture;
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
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * An optional description to this Payment Order
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     */
    public function setPlatforms($platforms)
    {
        $this->platforms = $platforms;
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
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
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
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }
}
