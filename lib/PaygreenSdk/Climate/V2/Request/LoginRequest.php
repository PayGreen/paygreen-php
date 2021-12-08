<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LoginRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string      $clientId
     * @param string      $username
     * @param string      $password
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getFirstAuthenticationRequest($clientId, $username, $password)
    {
        $violations = Validator::validateValue($clientId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
        $violations->addAll(Validator::validateValue($username, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));
        $violations->addAll(Validator::validateValue($password, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

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
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getRefreshTokenRequest($clientId, $refreshToken)
    {
        $violations = Validator::validateValue($clientId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
        $violations->addAll(Validator::validateValue($refreshToken, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

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