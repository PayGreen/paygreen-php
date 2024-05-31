<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class Instrument implements InstrumentInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $token;

    /**
     * @var bool
     */
    private $withAuthorization;

    /**
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWithAuthorization()
    {
        return $this->withAuthorization;
    }

    /**
     * @param bool $withAuthorization
     * @return self
     */
    public function setWithAuthorization($withAuthorization)
    {
        $this->withAuthorization = $withAuthorization;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}
