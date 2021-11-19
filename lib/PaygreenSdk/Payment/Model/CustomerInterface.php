<?php

namespace Paygreen\Sdk\Payment\Model;

interface CustomerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     * @return void
     */
    public function setId($id);

    /**
     * Reference to identify the user on the api
     *
     * @return string
     */
    public function getReference();

    /**
     * @param string $reference
     * @return void
     */
    public function setReference($reference);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $firstname
     * @return void
     */
    public function setFirstname($firstname);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $lastname
     * @return void
     */
    public function setLastname($lastname);

    /*
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /*
     * @return string
     */
    public function getCompanyName();

    /**
     * @param string $companyName
     * @return void
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCountryCode();

    /**
     * @param string $countryCode
     * @return void
     */
    public function setCountryCode($countryCode);
}
