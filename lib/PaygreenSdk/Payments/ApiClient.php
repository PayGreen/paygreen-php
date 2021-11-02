<?php

namespace Paygreen\Sdk\Payments;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Paygreen\Sdk\Core\Components\Config;
use Paygreen\Sdk\Core\Components\Environment;
use Paygreen\Sdk\Core\HttpClient;
use Paygreen\Sdk\Core\Logger;
use Paygreen\Sdk\Payments\Exceptions\InvalidApiVersion;
use Paygreen\Sdk\Payments\Exceptions\PaymentCreationException;
use Paygreen\Sdk\Payments\Interfaces\OrderInterface;
use Psr\Log\LoggerInterface;

class ApiClient extends HttpClient
{
    const API_BASE_URL_SANDBOX = 'https://sandbox.paygreen.fr';
    const API_BASE_URL_PROD = 'https://paygreen.fr';

    /** @var LoggerInterface */
    private $logger;

    private $config = [];

    /**
     * @throws InvalidApiVersion
     */
    public function __construct(LoggerInterface $logger = null)
    {
        if ($logger === null) {
            $this->logger = new Logger('payment');
        }

        $environment = new Environment(
            getenv('PG_PAYMENT_PUBLIC_KEY'),
            getenv('PG_PAYMENT_PRIVATE_KEY'),
            getenv('PG_PAYMENT_API_SERVER')
        );

        parent::__construct($environment);

        $this->loadConfig();
        $this->initClient();
    }

    /**
     * @param OrderInterface $order
     * @param int $amount
     * @param string $notifiedUrl
     * @param string $currency
     * @param string $paymentType
     * @param string $returnedUrl
     * @param array $metadata
     * @param array $eligibleAmount
     * @param string $ttl
     * @return Response
     * @throws PaymentCreationException
     * @throws Exception|GuzzleException
     */
    public function createCash(
        OrderInterface $order,
        $amount,
        $notifiedUrl,
        $paymentType = 'CB',
        $currency = 'EUR',
        $returnedUrl = '',
        $metadata = [],
        $eligibleAmount = [],
        $ttl = ''
    ) {
        $this->logger->info("Create '$paymentType' cash payment with an amount of '$amount'.");

        $requestConfig = $this->config['requests.create_cash'];

        $url = $this->parseUrlParameters(
            $this->getBaseUri() . $requestConfig['url'],
            [
                'ui' => $this->environment->getPublicKey()
            ]
        );

        $response = $this->client->request(
            $requestConfig['method'],
            $url,
            $this->buildOptions([
                'json' => [
                    'orderId' => 'PG-' . $order->getReference(),
                    'amount' => $amount,
                    'currency' => $currency,
                    'paymentType' => $paymentType,
                    'notifiedUrl' => $notifiedUrl,
                    'returnedUrl' => $returnedUrl,
                    'buyer' => (object) [
                        'id' => $order->getCustomer()->getId(),
                        'lastName' => $order->getCustomer()->getLastName(),
                        'firstName' => $order->getCustomer()->getFirstName(),
                        'country' => $order->getCustomer()->getCountryCode()
                    ],
                    'shippingAddress' => (object) [
                        'lastName' => $order->getShippingAddress()->getLastName(),
                        'firstName' => $order->getShippingAddress()->getFirstName(),
                        'address' => $order->getShippingAddress()->getStreet(),
                        'zipCode' => $order->getShippingAddress()->getZipCode(),
                        'city' => $order->getShippingAddress()->getCity(),
                        'country' => $order->getShippingAddress()->getCountryCode()
                    ],
                    'billingAddress' => (object) [
                        'lastName' => $order->getBillingAddress()->getLastName(),
                        'firstName' => $order->getBillingAddress()->getFirstName(),
                        'address' => $order->getBillingAddress()->getStreet(),
                        'zipCode' => $order->getBillingAddress()->getZipCode(),
                        'city' => $order->getBillingAddress()->getCity(),
                        'country' => $order->getBillingAddress()->getCountryCode()
                    ],
                    'metadata' => $metadata,
                    'eligibleAmount' => $eligibleAmount,
                    'ttl' => $ttl
                ]
            ], $requestConfig['private'])
        );

        if ($response->getStatusCode() !== 200) {
            throw new PaymentCreationException(
                "An error occurred while creating a payment task for order '{$order->getReference()}'."
            );
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return string
     */
    private function getBaseUri()
    {
        if ($this->environment->getEnvironment() === 'SANDBOX') {
            $baseUri = self::API_BASE_URL_SANDBOX;
        } else {
            $baseUri = self::API_BASE_URL_PROD;
        }

        return $baseUri;
    }

    /**
     * @return void
     */
    private function initClient()
    {
        $this->client = new Client([
            'defaults' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => $this->buildUserAgentHeader()
                ]
            ]
        ]);
    }

    /**
     * @throws InvalidApiVersion
     */
    private function loadConfig()
    {
        $config = new Config();
        $apiVersion = (int) getenv('PG_PAYMENT_API_VERSION');

        switch ($apiVersion) {
            case 2:
                $this->config = $config['payment.v2'];
                break;
            case 3:
                $this->config = $config['payment.v3'];
                break;
            default:
                throw new InvalidApiVersion('Invalid API version. Value should be 2 or 3.');
        }
    }

    /**
     * @param array $options
     * @param bool $private
     * @return array
     */
    private function buildOptions(array $options = [], $private = true)
    {
        if ($private) {
            $options['headers'] = [
                'Authorization' => 'Bearer ' . $this->environment->getPrivateKey()
            ];
        }

        return $options;
    }
}