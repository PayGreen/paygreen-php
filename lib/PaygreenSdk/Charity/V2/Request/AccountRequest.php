<?php

namespace Paygreen\Sdk\Charity\V2\Request;

use Psr\Http\Message\RequestInterface;

class AccountRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $clientId
     *
     * @return RequestInterface
     */
    public function getGetRequest($clientId)
    {
        return $this->requestFactory->create(
            '/account/' . urlencode($clientId),
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }
}