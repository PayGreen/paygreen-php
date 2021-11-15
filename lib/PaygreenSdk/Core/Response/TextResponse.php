<?php

namespace Paygreen\Sdk\Core\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class TextResponse implements ResponseInterface
{
    /** @var PsrResponseInterface */
    public $response;
    
    public function __construct(PsrResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'http_code' => $this->response->getStatusCode(),
            'data' => $this->getData(),
        );
    }
}