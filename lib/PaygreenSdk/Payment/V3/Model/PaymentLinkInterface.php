<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface PaymentLinkInterface
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
     * @return string
     */
    public function getExpiresAt();

    /**
     * @param string $expiresAt
     */
    public function setExpiresAt($expiresAt);
}