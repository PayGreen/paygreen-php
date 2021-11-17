<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Paygreen\Sdk\Payment\Model\Customer;

class Buyer extends Customer
{
    /**
     * @return array<string>
     */
    public function serialize()
    {
        return [
            'email' => $this->getEmail(),
            'first_name' => $this->getFirstname(),
            'last_name' => $this->getLastname(),
            'reference' => $this->getId(),
            'country' => $this->getCountryCode(),
        ];
    }
}
 