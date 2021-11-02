<?php

namespace Paygreen\Sdk\Payments;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Paygreen\Sdk\Core\Components\Environment;
use Paygreen\Sdk\Core\HttpClient;
use Paygreen\Sdk\Core\Logger;
use Paygreen\Sdk\Payments\Exceptions\PaymentCreationException;
use Paygreen\Sdk\Payments\Interfaces\OrderInterface;
use Psr\Log\LoggerInterface;

class ApiClient extends HttpClient
{
    const API_BASE_URL_SANDBOX = 'https://sandbox.paygreen.fr';
    const API_BASE_URL_PROD = 'https://paygreen.fr';

    /** @var LoggerInterface */
    private $logger;

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
     * @throws Exception
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

        $url = $this->parseUrlParameters(
            $this->getBaseUri() . '/api/{ui}/payins/transaction/cash',
            [
                'ui' => $this->environment->getPublicKey()
            ]
        );

        $response = $this->client->post($url, [
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
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->environment->getPrivateKey()
            ]
        ]);

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
}