<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\Model\Customer;

class Buyer extends Customer
{
    /**
     * @var string
     */
    private $reference;
    
    /**
     * @return array<string>
     */
    public function serialize()
    {
        return [
            'email' => $this->getEmail(),
            'first_name' => $this->getFirstname(),
            'last_name' => $this->getLastname(),
            'id' => $this->getReference(),
            'reference' => $this->getId(),
            'country' => $this->getCountryCode(),
        ];
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return void
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
}
 