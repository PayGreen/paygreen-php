<?php

namespace Paygreen\Sdk\Payment\V3\Request\Operation;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class OperationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $instrumentId
     * @param array $pagination
     *
     * @return Request|RequestInterface
     */
    public function getListRequest(
        $instrumentId,
        $pagination = []
    ) {
        $filters = ['instrument_id' => $instrumentId];

        return $this->requestFactory->create(
            "/payment/operations?". $this->getListParameters($filters, $pagination),
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