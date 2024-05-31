<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class Shop
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nationalId;

    /**
     * @var string
     */
    private $mcc;

    /**
     * @var int
     */
    private $annualProcessingVolume;

    /**
     * @var int
     */
    private $averageTransactionValue;

    /**
     * @var int
     */
    private $highestTransactionValue;

    /**
     * @var array
     */
    private $activityCategories;

    /**
     * @var string
     */
    private $activityDescription;

    /**
     * @var Address|string
     */
    private $address;

    /**
     * @var string
     */
    private $commercialName;

    /**
     * @var \DateTimeInterface
     */
    private $creationDate;

    /**
     * @var array
     */
    private $economicModel;

    /**
     * @var string
     */
    private $legalCategory;

    /**
     * @var string
     */
    private $primaryActivity;

    /**
     * @var array
     */
    private $productType;

    /**
     * @var string
     */
    private $websiteUrl;

    /**
     * @var string
     */
    private $legalNoticeUrl;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNationalId()
    {
        return $this->nationalId;
    }

    /**
     * @param string $nationalId
     * @return self
     */
    public function setNationalId($nationalId)
    {
        $this->nationalId = $nationalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMcc()
    {
        return $this->mcc;
    }

    /**
     * @param string $mcc
     * @return self
     */
    public function setMcc($mcc)
    {
        $this->mcc = $mcc;
        return $this;
    }

    /**
     * @return int
     */
    public function getAnnualProcessingVolume()
    {
        return $this->annualProcessingVolume;
    }

    /**
     * @param int $annualProcessingVolume
     * @return self
     */
    public function setAnnualProcessingVolume($annualProcessingVolume)
    {
        $this->annualProcessingVolume = $annualProcessingVolume;
        return $this;
    }

    /**
     * @return int
     */
    public function getAverageTransactionValue()
    {
        return $this->averageTransactionValue;
    }

    /**
     * @param int $averageTransactionValue
     * @return self
     */
    public function setAverageTransactionValue($averageTransactionValue)
    {
        $this->averageTransactionValue = $averageTransactionValue;
        return $this;
    }

    /**
     * @return int
     */
    public function getHighestTransactionValue()
    {
        return $this->highestTransactionValue;
    }

    /**
     * @param int $highestTransactionValue
     * @return self
     */
    public function setHighestTransactionValue($highestTransactionValue)
    {
        $this->highestTransactionValue = $highestTransactionValue;
        return $this;
    }

    /**
     * @return array
     */
    public function getActivityCategories()
    {
        return $this->activityCategories;
    }

    /**
     * @param array $activityCategories
     * @return self
     */
    public function setActivityCategories($activityCategories)
    {
        $this->activityCategories = $activityCategories;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivityDescription()
    {
        return $this->activityDescription;
    }

    /**
     * @param string $activityDescription
     * @return self
     */
    public function setActivityDescription($activityDescription)
    {
        $this->activityDescription = $activityDescription;
        return $this;
    }

    /**
     * @return Address|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address|string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommercialName()
    {
        return $this->commercialName;
    }

    /**
     * @param string $commercialName
     * @return self
     */
    public function setCommercialName($commercialName)
    {
        $this->commercialName = $commercialName;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTimeInterface $creationDate
     * @return self
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getEconomicModel()
    {
        return $this->economicModel;
    }

    /**
     * @param array $economicModel
     * @return self
     */
    public function setEconomicModel($economicModel)
    {
        $this->economicModel = $economicModel;
        return $this;
    }

    /**
     * @return string
     */
    public function getLegalCategory()
    {
        return $this->legalCategory;
    }

    /**
     * @param string $legalCategory
     * @return self
     */
    public function setLegalCategory($legalCategory)
    {
        $this->legalCategory = $legalCategory;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryActivity()
    {
        return $this->primaryActivity;
    }

    /**
     * @param string $primaryActivity
     * @return self
     */
    public function setPrimaryActivity($primaryActivity)
    {
        $this->primaryActivity = $primaryActivity;
        return $this;
    }

    /**
     * @return array
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param array $productType
     * @return self
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     * @return self
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getLegalNoticeUrl()
    {
        return $this->legalNoticeUrl;
    }

    /**
     * @param string $legalNoticeUrl
     * @return self
     */
    public function setLegalNoticeUrl($legalNoticeUrl)
    {
        $this->legalNoticeUrl = $legalNoticeUrl;
        return $this;
    }
}
