<?php

namespace Paygreen\Sdk\Payment\V3\Request\PublicKey;

use Exception;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class PublicKeyRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $publicKey
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($publicKey)
    {
        return $this->requestFactory->create(
            '/auth/public-keys/' . urlencode($publicKey),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}
