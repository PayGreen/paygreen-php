<?php

namespace Paygreen\Sdk\Payment\V2\Request;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class OAuthRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string      $ipAddress
     * @param string      $email
     * @param string      $name
     * @param null|string $phoneNumber
     * @param null|string $serverAddress
     *
     * @throws ConstraintViolationException
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
        $violations = Validator::validateValue($ipAddress, [
            new Assert\NotBlank(),
            new Assert\Ip(),
        ]);
        $violations->addAll(Validator::validateValue($email, [
            new Assert\NotBlank(),
            new Assert\Email(),
        ]));
        $violations->addAll(Validator::validateValue($name, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));
        $violations->addAll(Validator::validateValue($phoneNumber, new Assert\Type('string')));
        $violations->addAll(Validator::validateValue($serverAddress, new Assert\Type('string')));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

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
     * @throws ConstraintViolationException
     *
     * @return string
     */
    public function getAuthenticationPageRequest($clientId, $redirectUri, $responseType)
    {
        $violations = Validator::validateValue($clientId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
        $violations->addAll(Validator::validateValue($redirectUri, [
            new Assert\NotBlank(),
            new Assert\Url(),
        ]));
        $violations->addAll(Validator::validateValue($responseType, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

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
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getAuthenticationControlRequest($clientId, $code, $grantType)
    {
        $violations = Validator::validateValue($clientId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
        $violations->addAll(Validator::validateValue($code, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));
        $violations->addAll(Validator::validateValue($grantType, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

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
