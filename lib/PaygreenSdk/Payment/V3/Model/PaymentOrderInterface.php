<?php

namespace Paygreen\Sdk\Payment\V3\Model;


interface PaymentOrderInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * Your reference to this Payment Order
     *
     * @return string
     */
    public function getReference();

    /**
     * @param string $reference
     */
    public function setReference($reference);

    /**
     * @return int
     */
    public function getAmount();

    /**
     * The amount (in cts)
     *
     * @param int $amount
     */
    public function setAmount($amount);

    /**
     * @return array
     */
    public function getEligibleAmounts();

    /**
     * Key-value array of eligible amounts (in cts)
     * Keys can be food and travel.
     *
     * @param array $eligibleAmounts
     */
    public function setEligibleAmounts($eligibleAmounts);

    /**
     * @return bool
     */
    public function isAutoCapture();

    /**
     * If true, the operations will be automatically captured whenever possible.
     * Otherwise, you need to call the Capture endpoint. Default is true.
     *
     * @param bool $autoCapture
     */
    public function setAutoCapture($autoCapture);

    /**
     * @return BuyerInterface
     */
    public function getBuyer();

    /**
     * Existing Buyer ID, or new Buyer entity
     *
     * @param BuyerInterface $buyer
     */
    public function setBuyer($buyer);

    /**
     * @return string
     */
    public function getCaptureOn();

    /**
     * If you need us to capture the operations on a specific day and hour.
     *
     * @param string $captureOn
     */
    public function setCaptureOn($captureOn);

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     */
    public function setCurrency($currency);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * An optional description to this Payment Order
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getInstrument();

    /**
     * Existing Instrument ID - Required for merchant initiated payments
     *
     * @param string $instrument
     */
    public function setInstrument($instrument);

    /**
     * @return int
     */
    public function getMaxOperations();

    /**
     * The maximum number of operations. If the amount is not reached with this number of operations,
     * the Payment Order will automatically be canceled (and each authorized operations as well).
     * Default is null (no maximum).
     *
     * @param int $maxOperations
     */
    public function setMaxOperations($maxOperations);

    /**
     * @return bool
     */
    public function isMerchantInitiated();

    /**
     * @param bool $merchantInitiated
     */
    public function setMerchantInitiated($merchantInitiated);

    /**
     * @return bool
     */
    public function isPartialAllowed();

    /**
     * If true, the Payment Order will be successful immediately after an operation is Authorized,
     * regardless of the amount.
     * Default is false.
     *
     * @param bool $partial_allowed
     */
    public function setPartialAllowed($partial_allowed);

    /**
     * @return array
     */
    public function getPlatforms();

    /**
     * An array containing the platforms that can be processed through this Payment Order.
     * If not set, all the validated Platforms of your Shop will be available.
     *
     * @param array $platforms
     */
    public function setPlatforms($platforms);

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * The Shipping Address associated with this order.
     *
     * @param AddressInterface $shippingAddress
     */
    public function setShippingAddress($shippingAddress);

    /**
     * @return int
     */
    public function getShopId();

    /**
     * The beneficiary Shop ID. If you are a Marketplace, set the sub-entity ID here.
     *
     * @param int $shopId
     */
    public function setShopId($shopId);

    /**
     * @return array
     */
    public function getMetadata();

    /**
     * @param array $metadata
     */
    public function setMetadata($metadata);

    /**
     * @return int
     */
    public function getFees();

    /**
     * @param int $fees
     */
    public function setFees($fees);
}