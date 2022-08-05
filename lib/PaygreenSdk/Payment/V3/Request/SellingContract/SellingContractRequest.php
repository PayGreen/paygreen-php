<?php

namespace Paygreen\Sdk\Payment\V3\Request\SellingContract;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class SellingContractRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     */
    public function getListRequest($shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }
        
        $body = [
            'shop_id' => $shopId
        ];

        return $this->requestFactory->create(
            "/payment/selling-contracts",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $number
     * @param int $mcc
     * @param int $maxAmount
     * @param string $type
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(
        $number,
        $mcc,
        $maxAmount,
        $type,
        $shopId
    ) {
        $body = [
            'shop_id' => ($shopId === null) ? $this->environment->getShopId(): $shopId,
            'number' => $number,
            'mcc' => $mcc,
            'max_amount' => $maxAmount,
            'type' => $type
        ];

        return $this->requestFactory->create(
            "/payment/selling-contracts",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
