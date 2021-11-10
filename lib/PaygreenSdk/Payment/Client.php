<?php

namespace Paygreen\Sdk\Payment;

use Exception;
use Paygreen\Sdk\Core\Component\Environment;
use Paygreen\Sdk\Payment\Exception\InvalidApiVersionException;
use Http\Client\HttpClient as HttpClientInterface;
use Paygreen\Sdk\Core\Logger;
use Paygreen\Sdk\Payment\Component\Builder\RequestBuilder;
use Paygreen\Sdk\Payment\Component\Response\Response;
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

    /** @var RequestBuilder */
    protected $requestBuilder;

    /** @var Environment */
    protected $environment;

    /**
     * @param HttpClientInterface $client
     * @param LoggerInterface|null $logger
     * @throws InvalidApiVersionException
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

        $this->requestBuilder = new RequestBuilder($this->environment);
    }
    
    /**
     * @param RequestInterface $request
     * @return Response
     * @throws Exception
     */
    protected function sendRequest(RequestInterface $request)
    {
        try {
            $this->logger->info("Sending request '{$request->getUri()->getPath()}'.");

            /** @var ResponseInterface $response */
            $response = $this->client->sendRequest($request);
            
            $response = new Response($request, $response);

            if ($response->getHttpCode() >= 400) {
                $this->logger->error('Request error. ', [
                    'code' => $response->getHttpCode(),
                    'request' => $request
                ]);
            }

            return $response;
        } catch (HttpClientException $exception) {
            $this->logger->error("A client error occurred while sending request.", [$exception]);

            throw new Exception('Http client error.', $exception->getCode(), $exception);
        }
    }
}