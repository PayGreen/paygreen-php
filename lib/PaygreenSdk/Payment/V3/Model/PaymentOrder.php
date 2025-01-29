<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class PaymentOrder implements PaymentOrderInterface
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
    private $captureOn;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $instrument;

    /**
     * @var int
     */
    private $maxOperations;

    /**
     * @var bool
     */
    private $merchantInitiated;

    /**
     * @var bool
     */
    private $partial_allowed;

    /**
     * @var array
     */
    private $platforms;

    /**
     * @var AddressInterface
     */
    private $shippingAddress;

    /**
     * @var string
     */
    private $shopId;

    /**
     * @var int
     */
    private $fees;

    /**
     * @var string
     */
    private $returnUrl;

    /**
     * @var string
     */
    private $cancelUrl;

    /**
     * @var array
     */
    private $metadata;

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
     * @return array
     */
    public function getEligibleAmounts()
    {
        return $this->eligibleAmounts;
    }

    /**
     * @param array $eligibleAmounts
     * @return self
     */
    public function setEligibleAmounts($eligibleAmounts)
    {
        $this->eligibleAmounts = $eligibleAmounts;

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
    public function getCaptureOn()
    {
        return $this->captureOn;
    }

    /**
     * If you need us to capture the operations on a specific day and hour.
     *
     * @param string $captureOn
     * @return self
     */
    public function setCaptureOn($captureOn)
    {
        $this->captureOn = $captureOn;

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
     * @return string
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * Existing Instrument ID - Required for merchant initiated payments
     *
     * @param string $instrument
     * @return self
     */
    public function setInstrument($instrument)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxOperations()
    {
        return $this->maxOperations;
    }

    /**
     * The maximum number of operations. If the amount is not reached with this number of operations,
     * the Payment Order will automatically be canceled (and each authorized operations as well).
     * Default is null (no maximum).
     *
     * @param int $maxOperations
     * @return self
     */
    public function setMaxOperations($maxOperations)
    {
        $this->maxOperations = $maxOperations;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMerchantInitiated()
    {
        return $this->merchantInitiated;
    }

    /**
     * @param bool $merchantInitiated
     * @return self
     */
    public function setMerchantInitiated($merchantInitiated)
    {
        $this->merchantInitiated = $merchantInitiated;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPartialAllowed()
    {
        return $this->partial_allowed;
    }

    /**
     * If true, the Payment Order will be successful immediately after an operation is Authorized,
     * regardless of the amount.
     * Default is false.
     *
     * @param bool $partial_allowed
     * @return self
     */
    public function setPartialAllowed($partial_allowed)
    {
        $this->partial_allowed = $partial_allowed;

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
     * @return AddressInterface
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * The Shipping Address associated with this order.
     *
     * @param AddressInterface $shippingAddress
     * @return self
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;

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
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     * @return self
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return int
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * @param int $fees
     * @return self
     */
    public function setFees($fees)
    {
        $this->fees = $fees;

        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param string $returnUrl
     * @return self
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * @param string $cancelUrl
     * @return self
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;

        return $this;
    }
}
