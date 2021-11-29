<?php

namespace Paygreen\Sdk\Payment\V3\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Instrument implements InstrumentInterface
{
    /**
     * @var string
     */
    private $reference;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraints('reference', [
                new Assert\NotBlank(),
                new Assert\Type('string')
            ])
        ;
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
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
}
