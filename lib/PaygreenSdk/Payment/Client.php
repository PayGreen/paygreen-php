<?php

namespace Paygreen\Sdk\Payment;

use Exception;
use Paygreen\Sdk\Core\Environment;
use Http\Client\HttpClient as HttpClientInterface;
use Paygreen\Sdk\Core\Logger;
use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Http\Client\Exception as HttpClientException;

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

    /**
     * @param HttpClientInterface $client
     * @param LoggerInterface|null $logger
     */
    public function __construct(HttpClientInterface $client, LoggerInterface $logger = null)
    {
        $this->client = $client;

        if ($logger === null) {
            $this->logger = new Logger('api.payment');
        } else {
            $this->logger = $logger;
        }

        $this->environment = new Environment(
            getenv('PG_PAYMENT_PUBLIC_KEY'),
            getenv('PG_PAYMENT_PRIVATE_KEY'),
            getenv('PG_PAYMENT_API_SERVER'),
            getenv('PG_PAYMENT_API_VERSION')
        );

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
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws HttpClientException
     */
    protected function sendRequest(RequestInterface $request)
    {
        try {
            $this->logger->info("Sending request '{$request->getUri()->getPath()}'.");

            $response = $this->client->sendRequest($request);

            if ($response->getStatusCode() >= 400) {
                $this->logger->error('Request error. ', [
                    'code' => $response->getStatusCode(),
                    'request' => $request
                ]);
            }

            return $response;
        } catch (HttpClientException $exception) {
            $this->logger->error("A client error occurred while sending request.", [$exception]);

            throw new $exception;
        }
    }
}