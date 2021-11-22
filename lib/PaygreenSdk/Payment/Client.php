<?php

namespace Paygreen\Sdk\Payment;

use Http\Client\Exception as HttpClientException;
use Http\Client\HttpClient as HttpClientInterface;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Core\Logger;
use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class Client
{
    /** @var HttpClientInterface */
    protected $client;

    /** @var LoggerInterface */
    protected $logger;

    /** @var RequestFactory */
    protected $requestFactory;

    /** @var Environment */
    protected $environment;

    /** @var RequestInterface */
    private $lastRequest;

    /** @var ResponseInterface */
    private $lastResponse;

    public function __construct(
        HttpClientInterface $client,
        Environment $environment,
        LoggerInterface $logger = null
    ) {
        $this->client = $client;

        if (null === $logger) {
            $this->logger = new Logger('api.payment');
        } else {
            $this->logger = $logger;
        }

        $this->environment = $environment;
        $this->requestFactory = new RequestFactory($this->environment);
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
     * @throws HttpClientException
     *
     * @return ResponseInterface
     */
    protected function sendRequest(RequestInterface $request)
    {
        try {
            $this->logger->info("Sending request '{$request->getUri()->getPath()}'.");

            $response = $this->client->sendRequest($request);

            if ($response->getStatusCode() >= 400) {
                $this->logger->error('Request error. ', [
                    'code' => $response->getStatusCode(),
                    'request' => $request,
                ]);
            }

            return $response;
        } catch (HttpClientException $exception) {
            $this->logger->error('A client error occurred while sending request.', [$exception]);

            throw new $exception();
        }
    }
}
