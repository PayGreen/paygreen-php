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
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     */
    public function setWithAuthorization($withAuthorization)
    {
        $this->withAuthorization = $withAuthorization;
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
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}
