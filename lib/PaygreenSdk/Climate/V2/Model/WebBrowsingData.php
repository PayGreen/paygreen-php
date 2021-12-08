<?php

namespace Paygreen\Sdk\Climate\V2\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class WebBrowsingData
{
    /** @var string */
    private $userAgent;

    /** @var string */
    private $device;

    /** @var string */
    private $browser;

    /** @var integer */
    private $countImages;

    /** @var integer */
    private $countPages;

    /** @var integer */
    private $time;

    /** @var string */
    private $externalId;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('userAgent', new Assert\Type('string'))
            ->addPropertyConstraints('device', [
                new Assert\Type('string'),
                new Assert\Length([
                    'min' => 0,
                    'max' => 50
                ])
            ])
            ->addPropertyConstraints('browser', [
                new Assert\Type('string'),
                new Assert\Length([
                    'min' => 0,
                    'max' => 100
                ])
            ])
            ->addPropertyConstraint('countImages', new Assert\Type('integer'))
            ->addPropertyConstraints('countPages', [
                new Assert\NotBlank(),
                new Assert\Type('integer')
            ])
            ->addPropertyConstraint('time', new Assert\Type('integer'))
            ->addPropertyConstraints('externalId', [
                new Assert\Type('string'),
                new Assert\Length([
                    'min' => 0,
                    'max' => 255
                ])
            ])
        ;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param string $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param string $browser
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    /**
     * @return int
     */
    public function getCountImages()
    {
        return $this->countImages;
    }

    /**
     * @param int $countImages
     */
    public function setCountImages($countImages)
    {
        $this->countImages = $countImages;
    }

    /**
     * @return int
     */
    public function getCountPages()
    {
        return $this->countPages;
    }

    /**
     * @param int $countPages
     */
    public function setCountPages($countPages)
    {
        $this->countPages = $countPages;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }
}