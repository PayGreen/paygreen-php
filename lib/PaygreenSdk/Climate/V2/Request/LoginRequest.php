<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class LoginRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string      $clientId
     * @param string      $username
     * @param string      $password
     *
     * @return RequestInterface
     */
    public function getFirstAuthenticationRequest($clientId, $username, $password)
    {
        $body = [
            'client_id' => $clientId,
            'username' => $username,
            'password' => $password,
            'grant_type' => 'password',
        ];

        return $this->requestFactory->create(
            '/login',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->isJson()->getRequest();
    }

    /**
     * @param string      $clientId
     * @param string      $refreshToken
     *
     * @return RequestInterface
     */
    public function getRefreshTokenRequest($clientId, $refreshToken)
    {
        $body = [
            'client_id' => $clientId,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
        ];

        return $this->requestFactory->create(
            '/login',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->isJson()->getRequest();
    }
}