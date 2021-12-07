<?php

namespace Paygreen\Sdk\Payment\V2\Model;

interface CustomerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * Reference to identify the user on the api.
     *
     * @return null|string
     */
    public function getReference();

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
    public function getEmail();

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @return string
     */
    public function getCountryCode();
}
