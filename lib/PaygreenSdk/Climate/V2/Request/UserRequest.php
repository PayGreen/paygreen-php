<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Psr\Http\Message\RequestInterface;

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
            '/account/' . urlencode($clientId) . '/user/' . urlencode($username),
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
            '/account/me/user/me',
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
        return $this->requestFactory->create(
            '/carbon/public/projects?idUser=' . urlencode($userId),
            null,
            'GET'
        )->getRequest();
    }
}