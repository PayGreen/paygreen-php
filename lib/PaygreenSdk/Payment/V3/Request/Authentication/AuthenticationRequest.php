<?php

namespace Paygreen\Sdk\Payment\V3\Request\Authentication;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
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
            "/auth/authentication/{$shopId}/secret-key"
        )->isJson()->getRequest()->withAddedHeader('Authorization', $secretKey);
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return RequestInterface
     */
    public function getCredentialsRequest($username, $password)
    {
        $body = [
            'username' => $username,
            'password' => $password
        ];

        return $this->requestFactory->create(
            "/auth/authentication",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->isJson()->getRequest();
    }
}
