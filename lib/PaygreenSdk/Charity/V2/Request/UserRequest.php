<?php

namespace Paygreen\Sdk\Charity\V2\Request;

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
}