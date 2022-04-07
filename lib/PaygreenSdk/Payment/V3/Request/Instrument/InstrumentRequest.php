<?php

namespace Paygreen\Sdk\Payment\V3\Request\Instrument;

use Exception;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

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
        return $this->requestFactory->create(
            "/payment/instruments/{$instrumentReference}",
            null,
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }
}
