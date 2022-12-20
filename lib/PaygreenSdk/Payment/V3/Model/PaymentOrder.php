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
     * @return array
     */
    public function getEligibleAmounts()
    {
        return $this->eligibleAmounts;
    }

    /**
     * @param array $eligibleAmounts
     */
    public function setEligibleAmounts($eligibleAmounts)
    {
        $this->eligibleAmounts = $eligibleAmounts;
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
    public function getCaptureOn()
    {
        return $this->captureOn;
    }

    /**
     * If you need us to capture the operations on a specific day and hour.
     *
     * @param string $captureOn
     */
    public function setCaptureOn($captureOn)
    {
        $this->captureOn = $captureOn;
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
     */
    public function setInstrument($instrument)
    {
        $this->instrument = $instrument;
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
     */
    public function setMaxOperations($maxOperations)
    {
        $this->maxOperations = $maxOperations;
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
     */
    public function setMerchantInitiated($merchantInitiated)
    {
        $this->merchantInitiated = $merchantInitiated;
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
     */
    public function setPartialAllowed($partial_allowed)
    {
        $this->partial_allowed = $partial_allowed;
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
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
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
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
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
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
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
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
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
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;
    }
}
