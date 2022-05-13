<?php

namespace Paygreen\Sdk\Payment\V3\Request\Config;

use Psr\Http\Message\RequestInterface;

class ConfigRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return RequestInterface
     */
    public function getGetRequest()
    {
        $shopId = $this->environment->getShopId();

        return $this->requestFactory->create(
            "/payment/payment-configs?shop_id={$shopId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}