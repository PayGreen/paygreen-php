<?php

namespace Paygreen\Sdk\Payment\V3\Request\Instrument;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class InstrumentRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param int $instrumentReference
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getDeleteRequest($instrumentReference)
    {
        $violations = Validator::validateValue($instrumentReference, new Assert\NotBlank());

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        return $this->requestFactory->create(
            "/payment/instruments/{$instrumentReference}",
            null,
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }
}
