<?php

namespace Paygreen\Sdk\Payment\V3\Request\SellingContract;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\SellingContractInterface;
use Psr\Http\Message\RequestInterface;

class SellingContractRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     */
    public function getListRequest($shopId)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        return $this->requestFactory->create(
            "/payment/selling-contracts?shop_id={$shopId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param SellingContractInterface $sellingContract
     * @param string|null $shopId
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest(SellingContractInterface $sellingContract, $shopId = null) {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        $body = [
            'shop_id' => $shopId,
            'number' => $sellingContract->getNumber(),
            'mcc' => $sellingContract->getMcc(),
            'max_amount' => $sellingContract->getMaxAmount(),
            'type' => $sellingContract->getType()
        ];

        return $this->requestFactory->create(
            "/payment/selling-contracts",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
