<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\ModeEnum;

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
}
