<?php

namespace Paygreen\Sdk\Payment\V3\Request\Operation;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class OperationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param array $filters
     * @param array $pagination
     *
     * @return Request|RequestInterface
     */
    public function getListRequest(
        $filters = [],
        $pagination = []
    ) {
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

    /**
     * @param string $operationId
     * @param int|null $amount
     * @param string|null $status
     *
     * @return Request|RequestInterface
     */
    public function getUpdateRequest($operationId, $amount = null, $status = null)
    {
        $body = [
            'amount' => $amount,
            'status' => $status
        ];

        return $this->requestFactory->create(
            "/payment/operations/$operationId",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}