<?php

namespace Paygreen\Sdk\Payment\V3\Request\Authentication;

use Psr\Http\Message\RequestInterface;

class AuthenticationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        $shopId = $this->environment->getShopId();
        $secretKey = $this->environment->getSecretKey();

        return $this->requestFactory->create(
            '/auth/authentication/' . urlencode($shopId) . '/secret-key'
        )->isJson()->getRequest()->withAddedHeader('Authorization', $secretKey);
    }
}
