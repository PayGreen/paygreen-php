<?php

namespace Paygreen\Sdk\Charity\V2\Request;

use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PartnershipRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return RequestInterface
     */
    public function getGroupsRequest()
    {
        return $this->requestFactory->create(
            "/partnership-group",
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }

    /**
     * @param string $externalId
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getGroupRequest($externalId)
    {
        $violations = Validator::validateValue($externalId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]);

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        return $this->requestFactory->create(
            "/partnership-group/{$externalId}",
            null,
            'GET'
        )->withAuthorization()->getRequest();
    }
}