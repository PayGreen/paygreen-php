<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $clientId
     * @param string $username
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getGetRequest($clientId, $username)
    {
        $violations = Validator::validateValue($clientId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);
        $violations->addAll(Validator::validateValue($clientId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        return $this->requestFactory->create(
            "/account/{$clientId}/user/{$username}",
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }

    /***
     * @return RequestInterface
     */
    public function getGetCurrentUserRequest()
    {
        return $this->requestFactory->create(
            "/account/me/user/me",
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }

    /**
     * @param string $userId
     * 
     * @return RequestInterface
     */
    public function getGetFavoriteProjectRequest($userId)
    {
        $query = ['idUser' => $userId];
        
        return $this->requestFactory->create(
            "/carbon/public/projects?" . http_build_query($query),
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }
}