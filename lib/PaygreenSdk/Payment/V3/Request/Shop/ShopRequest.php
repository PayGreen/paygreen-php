<?php

namespace Paygreen\Sdk\Payment\V3\Request\Shop;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class ShopRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getListRequest()
    {

        return $this->requestFactory->create(
            "/account/shops",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        return $this->requestFactory->create(
            "/account/shops/$shopId",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $name
     * @param string $nationalId
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest($name, $nationalId)
    {
        $body = [
          'name' => $name,
          'national_id' => $nationalId
        ];

        return $this->requestFactory->create(
            "/account/shops",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
