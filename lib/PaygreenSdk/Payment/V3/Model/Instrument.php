<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class Instrument implements InstrumentInterface
{
    /**
     * @var string
     */
    private $reference;

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
