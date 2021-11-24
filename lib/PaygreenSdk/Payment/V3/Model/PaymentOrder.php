<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\Model\OrderInterface;


class PaymentOrder
{
    /**
     * @var OrderInterface
     */
    private $order;

    /**
     * @var string
     */
    private $paymentMode = "instant";

    /**
     * @var bool
     */
    private $autoCapture = false;

    /**
     * @var string
     */
    private $integrationMode = "hosted_fields";

    /**
     * @var bool
     */
    private $partialAllowed = false;

    /**
     * @var array
     */
    private $platforms = ["bank_card","conecs"];

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
     * @return void
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
     * @return void
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
