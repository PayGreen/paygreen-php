<?php

namespace Paygreen\Sdk\Core\Component\Response;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var RequestInterface
     */
    private $request;
    
    /** @var int */
    private $httpCode;
    
    /** @var mixed */
    private $data;
    
    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->httpCode = $response->getStatusCode();
        $this->data = $this->format($response->getBody()->getContents());
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'http_code' => $this->httpCode,
            'data' => $this->data
        );
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function format($data)
    {
        return $data;
    }
}