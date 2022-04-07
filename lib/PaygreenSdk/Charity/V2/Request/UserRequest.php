<?php

namespace Paygreen\Sdk\Charity\V2\Request;

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
}