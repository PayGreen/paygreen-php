<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Psr\Http\Message\RequestInterface;

class TokenRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $footprintId
     *
     * @return RequestInterface
     */
    public function getGetRequest($footprintId)
    {
        return $this->requestFactory->create(
            '/tokens/footprint/' . urlencode($footprintId),
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }
}