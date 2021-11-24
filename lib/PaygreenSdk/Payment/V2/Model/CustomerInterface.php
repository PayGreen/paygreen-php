<?php

namespace Paygreen\Sdk\Payment\V2\Model;

interface CustomerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * Reference to identify the user on the api.
     *
     * @return null|string
     */
    public function getReference();

    /**
     * @param string $reference
     */
    public function setReference($reference);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $lastname
     */
    public function setLastname($lastname);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCountryCode();

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode);
}
