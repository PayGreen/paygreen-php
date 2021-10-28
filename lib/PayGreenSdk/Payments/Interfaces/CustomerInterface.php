<?php

namespace PayGreenSdk\Payments\Interfaces;

interface CustomerInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return string
     */
    public function getCountryCode();
}
