<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Enum\CycleEnum;
use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\ModeEnum;

interface PaymentOrderInterface
{
    /**
     * @return array
     */
    public function getPlatforms();

    /**
     * @param array $platforms
     */
    public function setPlatforms($platforms);

    /**
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * @param OrderInterface $order
     */
    public function setOrder($order);

    /**
     * @return ModeEnum
     */
    public function getPaymentMode();

    /**
     * @param ModeEnum $paymentMode
     */
    public function setPaymentMode($paymentMode);

    /**
     * @return bool
     */
    public function getAutoCapture();

    /**
     * @param bool $autoCapture
     */
    public function setAutoCapture($autoCapture);

    /**
     * @return IntegrationModeEnum
     */
    public function getIntegrationMode();

    /**
     * @param IntegrationModeEnum $integrationMode
     */
    public function setIntegrationMode($integrationMode);

    /**
     * @return bool
     */
    public function isPartialAllowed();

    /**
     * @param bool $partialAllowed
     */
    public function setPartialAllowed($partialAllowed);

    /**
     * @return string
     */
    public function getCancelUrl();

    /**
     * @param string $cancelUrl
     */
    public function setCancelUrl($cancelUrl);

    /**
     * @return CycleEnum
     */
    public function getCycle();

    /**
     * @param CycleEnum $cycle
     */
    public function setCycle($cycle);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @return int
     */
    public function getEligibleAmount();

    /**
     * @param int $eligibleAmount
     */
    public function setEligibleAmount($eligibleAmount);

    /**
     * @return int
     */
    public function getFirstAmount();

    /**
     * @param int $firstAmount
     */
    public function setFirstAmount($firstAmount);

    /**
     * @return int
     */
    public function getInstrumentId();

    /**
     * @param int $instrumentId
     */
    public function setInstrumentId($instrumentId);

    /**
     * @return bool
     */
    public function isMerchantInitiated();

    /**
     * @param bool $merchantInitiated
     */
    public function setMerchantInitiated($merchantInitiated);

    /**
     * @return string
     */
    public function getNotificationUrl();

    /**
     * @param string $notificationUrl
     */
    public function setNotificationUrl($notificationUrl);

    /**
     * @return int
     */
    public function getOccurences();

    /**
     * @param int $occurences
     */
    public function setOccurences($occurences);

    /**
     * @return int
     */
    public function getPreviousOrderId();

    /**
     * @param int $previousOrderId
     */
    public function setPreviousOrderId($previousOrderId);

    /**
     * @return int
     */
    public function getPlatformsShopId();

    /**
     * @param int $platformsShopId
     */
    public function setPlatformsShopId($platformsShopId);

    /**
     * @return string
     */
    public function getPaymentDay();

    /**
     * @param string $paymentDay
     */
    public function setPaymentDay($paymentDay);

    /**
     * @return string
     */
    public function getReturnUrl();

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl);

    /**
     * @return string
     */
    public function getStartAt();

    /**
     * @param string $startAt
     */
    public function setStartAt($startAt);

    /**
     * @return int
     */
    public function getInstrumentTTL();

    /**
     * @param int $instrumentTTL
     */
    public function setInstrumentTTL($instrumentTTL);
}
