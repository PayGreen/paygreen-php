<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
            "/account/{$clientId}",
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }
}