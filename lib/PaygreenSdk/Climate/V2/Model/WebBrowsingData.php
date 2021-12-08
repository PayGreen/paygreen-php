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
    private $imageCount;

    /** @var integer */
    private $pageCount;

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
            ->addPropertyConstraint('imageCount', new Assert\Type('integer'))
            ->addPropertyConstraints('pageCount', [
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
    public function getImageCount()
    {
        return $this->imageCount;
    }

    /**
     * @param int $imageCount
     */
    public function setImageCount($imageCount)
    {
        $this->imageCount = $imageCount;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * @param int $pageCount
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;
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