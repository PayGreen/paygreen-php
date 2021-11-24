<?php

namespace Paygreen\Sdk\Core\Response;

use Paygreen\Sdk\Core\Exception\ResponseMalformedException;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class JsonResponse
{
    /** @var ResponseInterface */
    public $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @throws ResponseMalformedException
     *
     * @return stdClass
     */
    public function getData()
    {
        $data = json_decode($this->response->getBody()->getContents());

        if (!$data instanceof stdClass) {
            throw new ResponseMalformedException('Invalid JSON result.');
        }

        return $data;
    }

    /**
     * @throws ResponseMalformedException
     *
     * @return array<int|stdClass|string>
     */
    public function toArray()
    {
        return [
            'http_code' => $this->response->getStatusCode(),
            'data' => $this->getData(),
        ];
    }
}
