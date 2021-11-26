<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Buyer implements BuyerInterface, GroupSequenceProviderInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * Reference to identify the user on the api.
     *
     * @var null|string
     */
    private $reference;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $companyName;

    /**
     * @var Address
     */
    private $billingAddress;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->setGroupSequenceProvider(true);

        $metadata
            ->addPropertyConstraint('id', new Assert\NotBlank(['groups' => ['no_reference']]))
            ->addPropertyConstraint('reference', new Assert\NotBlank(['groups' => ['reference']]))
            ->addPropertyConstraints('firstname', [
                new Assert\NotBlank(['groups' => ['no_reference']]),
                new Assert\Type(['groups' => ['no_reference'], 'type' => 'string']),
            ])
            ->addPropertyConstraints('lastname', [
                new Assert\NotBlank(['groups' => ['no_reference']]),
                new Assert\Type(['groups' => ['no_reference'], 'type' => 'string']),
            ])
            ->addPropertyConstraints('email', [
                new Assert\NotBlank(['groups' => ['no_reference']]),
                new Assert\Email(),
            ])
            ->addPropertyConstraints('billingAddress', [
                new Assert\NotBlank(['groups' => ['no_reference']]),
                new Assert\Type(['groups' => ['no_reference'], 'type' => AddressInterface::class]),
                new Assert\Valid(['groups' => ['no_reference']]),
            ])
            ->addPropertyConstraint('countryCode', new Assert\Type(['groups' => ['no_reference'], 'type' => 'string']))
            ->addPropertyConstraint('companyName', new Assert\Type(['groups' => ['no_reference'], 'type' => 'string']))
        ;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return null|string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function getGroupSequence()
    {
        return [
            null === $this->getReference() ? 'no_reference' : 'reference',
        ];
    }
}
