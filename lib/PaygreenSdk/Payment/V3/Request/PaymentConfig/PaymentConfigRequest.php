<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentConfig;

use Psr\Http\Message\RequestInterface;

class PaymentConfigRequest extends \Paygreen\Sdk\Core\Request\Request
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