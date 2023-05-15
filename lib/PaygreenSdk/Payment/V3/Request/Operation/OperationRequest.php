<?php

namespace Paygreen\Sdk\Payment\V3\Request\Operation;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class OperationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $instrumentId
     * @param int $maxPerPage
     * @param int $page
     *
     * @return Request|RequestInterface
     */
    public function getListRequest(
        $instrumentId,
        $maxPerPage = 10,
        $page = 1
    ) {
        $parameters = [
            'instrument_id' => $instrumentId,
            'max_per_page' => $maxPerPage,
            'page' => $page
        ];

        return $this->requestFactory->create(
            "/payment/operations?".http_build_query($parameters),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $operationId
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($operationId)
    {
        return $this->requestFactory->create(
            "/payment/operations/$operationId",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}