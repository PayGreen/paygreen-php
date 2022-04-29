<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Enum\CycleEnum;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PaymentOrder implements PaymentOrderInterface
{
    /**
     * @var OrderInterface
     */
    private $order;

    /**
     * @var string
     */
    private $paymentMode;

    /**
     * @var bool
     */
    private $autoCapture;

    /**
     * @var string
     */
    private $integrationMode;

    /**
     * @var bool
     */
    private $partialAllowed;

    /**
     * @var array
     */
    private $platforms;

    /**
     * @var int
     */
    private $platformsShopId;

    /**
     * @var string
     */
    private $cancelUrl;

    /**
     * @var string
     */
    private $cycle;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $eligibleAmount;

    /**
     * @var int
     */
    private $firstAmount;

    /**
     * @var int
     */
    private $instrumentId;

    /**
     * @var int
     */
    private $instrumentTTL;

    /**
     * @var bool
     */
    private $merchantInitiated = false;

    /**
     * @var string
     */
    private $notificationUrl;

    /**
     * @var int
     */
    private $occurences;

    /**
     * @var int
     */
    private $previousOrderId;

    /**
     * @var string
     */
    private $paymentDay;

    /**
     * @var string
     */
    private $returnUrl;

    /**
     * @var string
     */
    private $startAt;

    /**
     * @var string
     */
    private $objectSecret;

    /**
     * @return array
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * @param array $platforms
     */
    public function setPlatforms($platforms)
    {
        $this->platforms = $platforms;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param OrderInterface $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getPaymentMode()
    {
        return $this->paymentMode;
    }

    /**
     * @param string $paymentMode
     */
    public function setPaymentMode($paymentMode)
    {
        $this->paymentMode = $paymentMode;
    }

    /**
     * @return bool
     */
    public function getAutoCapture()
    {
        return $this->autoCapture;
    }

    /**
     * @param bool $autoCapture
     */
    public function setAutoCapture($autoCapture)
    {
        $this->autoCapture = $autoCapture;
    }

    /**
     * @return string
     */
    public function getIntegrationMode()
    {
        return $this->integrationMode;
    }

    /**
     * @param string $integrationMode
     */
    public function setIntegrationMode($integrationMode)
    {
        $this->integrationMode = $integrationMode;
    }

    /**
     * @return bool
     */
    public function isPartialAllowed()
    {
        return $this->partialAllowed;
    }

    /**
     * @param bool $partialAllowed
     */
    public function setPartialAllowed($partialAllowed)
    {
        $this->partialAllowed = $partialAllowed;
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

    /**
     * @return string
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param string $cycle
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getEligibleAmount()
    {
        return $this->eligibleAmount;
    }

    /**
     * @param int $eligibleAmount
     */
    public function setEligibleAmount($eligibleAmount)
    {
        $this->eligibleAmount = $eligibleAmount;
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

    /**
     * @return int
     */
    public function getInstrumentId()
    {
        return $this->instrumentId;
    }

    /**
     * @param int $instrumentId
     */
    public function setInstrumentId($instrumentId)
    {
        $this->instrumentId = $instrumentId;
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
     * @return string
     */
    public function getNotificationUrl()
    {
        return $this->notificationUrl;
    }

    /**
     * @param string $notificationUrl
     */
    public function setNotificationUrl($notificationUrl)
    {
        $this->notificationUrl = $notificationUrl;
    }

    /**
     * @return int
     */
    public function getOccurences()
    {
        return $this->occurences;
    }

    /**
     * @param int $occurences
     */
    public function setOccurences($occurences)
    {
        $this->occurences = $occurences;
    }

    /**
     * @return int
     */
    public function getPreviousOrderId()
    {
        return $this->previousOrderId;
    }

    /**
     * @param int $previousOrderId
     */
    public function setPreviousOrderId($previousOrderId)
    {
        $this->previousOrderId = $previousOrderId;
    }

    /**
     * @return int
     */
    public function getPlatformsShopId()
    {
        return $this->platformsShopId;
    }

    /**
     * @param int $platformsShopId
     */
    public function setPlatformsShopId($platformsShopId)
    {
        $this->platformsShopId = $platformsShopId;
    }

    /**
     * @return string
     */
    public function getPaymentDay()
    {
        return $this->paymentDay;
    }

    /**
     * @param string $paymentDay
     */
    public function setPaymentDay($paymentDay)
    {
        $this->paymentDay = $paymentDay;
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
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * @param string $startAt
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;
    }

    /**
     * @return int
     */
    public function getInstrumentTTL()
    {
        return $this->instrumentTTL;
    }

    /**
     * @param int $instrumentTTL
     */
    public function setInstrumentTTL($instrumentTTL)
    {
        $this->instrumentTTL = $instrumentTTL;
    }

    /**
     * @return string
     */
    public function getObjectSecret()
    {
        return $this->objectSecret;
    }

    /**
     * @param string $objectSecret
     */
    public function setObjectSecret($objectSecret)
    {
        $this->objectSecret = $objectSecret;
    }
}
