<?php

namespace Paygreen\Sdk\Payment\V3\Model;

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
     * @return string
     */
    public function getPaymentMode();

    /**
     * @param string $paymentMode
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
     * @return string
     */
    public function getIntegrationMode();

    /**
     * @param string $integrationMode
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
}
