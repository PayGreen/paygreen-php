<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentConfig;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class PaymentConfigRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string|null $shopId
     * @return RequestInterface
     */
    public function getGetRequest($shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId($shopId);
        }

        return $this->requestFactory->create(
            "/payment/payment-configs?shop_id={$shopId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $platform
     * @param string $currency
     * @param string[] $config
     * @param string|null $sellingContractId
     * @param string|null $shopId
     *
     * @return RequestInterface
     */
    public function getCreateRequest(
        $platform,
        $currency,
        array $config,
        $sellingContractId = null,
        $shopId = null
    ) {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId($shopId);
        }

        $body = [
            'shop_id' => $shopId,
            'platform' => $platform,
            'currency' => $currency,
            'selling_contract' => $sellingContractId,
            'config' => $config
        ];

        return $this->requestFactory->create(
            "/payment/payment-configs",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}