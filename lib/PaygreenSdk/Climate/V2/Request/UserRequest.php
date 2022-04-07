<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $clientId
     * @param string $username
     *
     * @return RequestInterface
     */
    public function getGetRequest($clientId, $username)
    {
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
        )->getRequest();
    }
}