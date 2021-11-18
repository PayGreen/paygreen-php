<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\Model\OrderInterface;
use stdClass;

class PaymentOrder
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
     * @return array<string,bool|int|stdClass|string>
     */
    public function serialize() {
        $order = $this->getOrder();

        return [
            'amount' => $order->getAmount(),
            'currency' => $order->getCurrency(),
            'paymentMode' => $this->getPaymentMode(),
            'reference' => $order->getReference(),
            'auto_capture' => $this->getAutoCapture(),
            'integration_mode' => $this->getIntegrationMode(),
            'buyer' => (object) [
                'email' => $order->getCustomer()->getEmail(),
                'firstName' => $order->getCustomer()->getFirstName(),
                'lastName' => $order->getCustomer()->getLastName(),
                'reference' => $order->getCustomer()->getId(),
                'country' => $order->getCustomer()->getCountryCode()
            ]
        ];
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

}
