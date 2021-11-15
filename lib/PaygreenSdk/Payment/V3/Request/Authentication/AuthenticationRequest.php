<?php

namespace Paygreen\Sdk\Payment\V3\Request\Authentication;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class AuthenticationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getRequest()
    {
        $publicKey = $this->environment->getPublicKey();
        $privateKey = $this->environment->getPrivateKey();
        
        return $this->requestFactory->create(
            "/auth/authentication/$publicKey/secret-key",
            [],
            'POST',
            false
        )->withAddedHeader('Authorization', $privateKey);
    }
}