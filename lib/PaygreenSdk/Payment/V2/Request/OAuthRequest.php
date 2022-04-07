<?php

namespace Paygreen\Sdk\Payment\V2\Request;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class OAuthRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string      $ipAddress
     * @param string      $email
     * @param string      $name
     * @param null|string $phoneNumber
     * @param null|string $serverAddress
     *
     * @return RequestInterface
     */
    public function getCreateTokenRequest(
        $ipAddress,
        $email,
        $name,
        $phoneNumber = null,
        $serverAddress = null
    ) {
        $body = [
            'ipAddress' => $ipAddress,
            'serverAddress' => $serverAddress,
            'email' => $email,
            'name' => $name,
            'phoneNumber' => $phoneNumber,
        ];

        return $this->requestFactory->create(
            '/api/auth',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->isJson()->getRequest();
    }

    /**
     * @param string $clientId
     * @param string $redirectUri
     * @param string $responseType
     *
     * @return string
     */
    public function getAuthenticationPageRequest($clientId, $redirectUri, $responseType)
    {
        $body = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => $responseType,
        ];

        $body = (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body);

        return (string) $this->requestFactory->create(
            '/api/auth/authorize?'.http_build_query($body),
            null,
            'GET'
        )->getRequest()->getUri();
    }

    /**
     * @param string $clientId
     * @param string $code
     * @param string $grantType
     *
     * @return RequestInterface
     */
    public function getAuthenticationControlRequest($clientId, $code, $grantType)
    {
        $body = [
            'client_id' => $clientId,
            'grant_type' => $grantType,
            'code' => $code,
        ];

        return $this->requestFactory->create(
            '/api/auth/accessToken',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->isJson()->getRequest();
    }
}
