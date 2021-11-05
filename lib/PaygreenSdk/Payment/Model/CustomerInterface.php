<?php

namespace Paygreen\Sdk\Payment\Model;

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

    /*
     * @return string
     */
    public function getEmail();

    /*
     * @return string
     */
    public function getCompanyName();

    /**
     * @return string
     */
    public function getCountryCode();
}
