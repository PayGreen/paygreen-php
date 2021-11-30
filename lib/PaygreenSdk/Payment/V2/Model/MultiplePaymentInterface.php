<?php

namespace Paygreen\Sdk\Payment\V2\Model;

interface MultiplePaymentInterface
{
    /**
     * @return int
     */
    public function getCycle();

    /**
     * @return int
     */
    public function getCount();

    /**
     * @return int
     */
    public function getDay();

    /**
     * @return int
     */
    public function getStartAt();

    /**
     * @return int
     */
    public function getFirstAmount();
}
