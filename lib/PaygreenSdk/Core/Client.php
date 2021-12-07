<?php

namespace Paygreen\Sdk\Core;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class Client
{
    protected $client;

    /** @var LoggerInterface */
    protected $logger;

    /** @var RequestInterface */
    private $lastRequest;

    /** @var ResponseInterface */
    private $lastResponse;

    public function __construct(
        $client,
        LoggerInterface $logger = null
    ) {
        $this->client = $client;

        if (null === $logger) {
            $this->logger = new NullLogger();
        } else {
            $this->logger = $logger;
        }
    }

    /**
     * @param string $bearer
     */
    public function setBearer($bearer)
    {
        $this->environment->setBearer($bearer);
    }

    /**
     * @return RequestInterface
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param RequestInterface $lastRequest
     */
    protected function setLastRequest($lastRequest)
    {
        $this->lastRequest = $lastRequest;
    }

    /**
     * @param ResponseInterface $lastResponse
     */
    protected function setLastResponse($lastResponse)
    {
        $this->lastResponse = $lastResponse;
    }

    /**
     * @return ResponseInterface
     */
    protected function sendRequest(RequestInterface $request)
    {
        $this->logger->info("Sending request '{$request->getUri()->getPath()}'.");

        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() >= 400) {
            $this->logger->error('Request error. ', [
                'code' => $response->getStatusCode(),
                'request' => $request,
            ]);
        }

        return $response;
    }
}
