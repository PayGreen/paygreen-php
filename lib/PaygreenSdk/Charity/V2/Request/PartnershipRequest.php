<?php

namespace Paygreen\Sdk\Charity\V2\Request;

use Psr\Http\Message\RequestInterface;

class PartnershipRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return RequestInterface
     */
    public function getGroupsRequest()
    {
        return $this->requestFactory->create(
            '/partnership-group',
            null,
            'GET'
        )->withAuthorization()->withTestMode()->getRequest();
    }

    /**
     * @param string $externalId
     *
     * @return RequestInterface
     */
    public function getGroupRequest($externalId)
    {
        return $this->requestFactory->create(
            '/partnership-group/' . urlencode($externalId),
            null,
            'GET'
        )->withAuthorization()->withTestMode()->getRequest();
    }

    /**
     * @return RequestInterface
     */
    public function getDefaultGroup()
    {
        return $this->requestFactory->create(
            '/partnership-group?isDefault=1',
            null,
            'GET'
        )->withAuthorization()->withTestMode()->getRequest();
    }
}