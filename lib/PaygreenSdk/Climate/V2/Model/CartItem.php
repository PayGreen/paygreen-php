<?php

namespace Paygreen\Sdk\Climate\V2\Model;

class CartItem
{
    /** @var string */
    private $productReference;

    /** @var int */
    private $quantity;

    /** @var int */
    private $priceWithoutTaxes;

    /**
     * @return string
     */
    public function getProductReference()
    {
        return $this->productReference;
    }

    /**
     * @param string $productReference
     */
    public function setProductReference($productReference)
    {
        $this->productReference = $productReference;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getPriceWithoutTaxes()
    {
        return $this->priceWithoutTaxes;
    }

    /**
     * @param int $priceWithoutTaxes
     */
    public function setPriceWithoutTaxes($priceWithoutTaxes)
    {
        $this->priceWithoutTaxes = $priceWithoutTaxes;
    }
}