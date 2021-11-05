<?php

namespace Paygreen\Sdk\Core;

use Http\Client\Curl\Client;
use Http\Client\Exception as HttpClientException;
use Http\Client\HttpClient as HttpClientInterface;
use Http\Discovery\HttpClientDiscovery;
use Paygreen\Sdk\Core\Components\Environment;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements HttpClientInterface
{
    /** @var Client */
    private $client;

    /** @var Environment */
    private $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;

        $this->client = HttpClientDiscovery::find();
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws HttpClientException
     */
    public function sendRequest(RequestInterface $request)
    {
        return $this->client->sendRequest($request);
    }
}