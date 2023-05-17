<?php

namespace Paygreen\Sdk\Payment\V2\Request;

use Psr\Http\Message\RequestInterface;

class ShopRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return RequestInterface
     */
    public function getGetRequest()
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            '/api/' . urlencode($publicKey) . '/shop',
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}