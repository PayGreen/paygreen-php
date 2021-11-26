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
        $content = $this->response->getBody()->getContents();
        $data = new stdClass();

        if ($content) {
            $data = json_decode($content);
        }

        if (!$data instanceof stdClass) {
            throw new ResponseMalformedException('Invalid JSON result.');
        }

        return $data;
    }

    /**
     * @throws ResponseMalformedException
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'http_code' => $this->response->getStatusCode(),
            'data' => (array)$this->getData(),
        ];
    }
}
