<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Exception;
use GuzzleHttp\Psr7\MultipartStream;
use Paygreen\Sdk\Climate\V2\Model\CartItem;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class ProductRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $footprintId
     * @param string $productExternalReference
     * @param integer $quantity
     * 
     * @return RequestInterface
     */
    public function getAddProductDataRequest(
        $footprintId,
        $productExternalReference,
        $quantity
    ) {
        $body = [
            'productExternalReference' => $productExternalReference,
            'quantity' => $quantity
        ];

        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '/products',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param CartItem[] $cartItems
     *
     * @throws Exception
     * 
     * @return RequestInterface
     */
    public function getAddProductsDataRequest($footprintId, $cartItems)
    {
        $products = array();

        foreach ($cartItems as $cartItem) {
            $products[] = array(
                'productExternalReference' => $cartItem->getProductReference(),
                'quantity' => $cartItem->getQuantity(),
                'exTaxPriceInCents' => $cartItem->getPriceWithoutTaxes()
            );
        }

        $body = ['products' => $products];

        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '/product-cart',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $productExternalReference
     * @param string $productName
     * @param null|string $emissionExternalId
     *
     * @return RequestInterface
     */
    public function getCreateProductReferenceRequest(
        $productExternalReference,
        $productName,
        $emissionExternalId = null
    ) {
        $body = [
            'productExternalReference' => $productExternalReference,
            'productName' => $productName,
            'emissionExternalId' => $emissionExternalId,
        ];

        return $this->requestFactory->create(
            '/carbon/products/references',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param null|string $productExternalReference
     *
     * @throws Exception
     * 
     * @return RequestInterface
     */
    public function getDeleteProductDataRequest($footprintId, $productExternalReference = null)
    {
        if (!empty($productExternalReference)) {
            $url = '/carbon/footprints/' . urlencode($footprintId) . '/products/' . urlencode($productExternalReference);
        } else {
            $url = '/carbon/footprints/' . urlencode($footprintId) . '/products';
        }

        return $this->requestFactory->create(
            $url,
            null,
            'DELETE'
        )->withAuthorization()->withTestMode()->getRequest();
    }

    /**
     * @param string $filepath
     *
     * @throws Exception
     * 
     * @return RequestInterface
     */
    public function getExportProductCatalogRequest($filepath)
    {
        $multipart = new MultipartStream([
            [
                'name' => 'inputCsv',
                'contents' => fopen($filepath, 'r'),
                'filename' => 'product_catalog.csv'
            ]
        ]);

        return $this->requestFactory->create(
            '/carbon/products/catalog',
            $multipart,
            'POST',
            [
                'Accept' => '*/*',
                'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary(),
                'Accept-Encoding' => 'gzip, deflate, br',
                'Cache-Control' => 'no-cache'
            ]
        )->withAuthorization()->withTestMode()->getRequest();
    }
}