<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface InstrumentInterface
{
    /**
     * @return string
     */
    public function getReference();

    /**
     * @param string $reference
     * @return void
     */
    public function setReference($reference);
}
