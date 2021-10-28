<?php

namespace PayGreenSdk\Payments;

use GuzzleHttp\Client;
use PayGreenSdk\Core\Components\Environment;
use PayGreenSdk\Core\HttpClient;

class ApiClient extends HttpClient
{
    const API_BASE_URL_SANDBOX = 'https://sandbox.paygreen.fr';
    const API_BASE_URL_PROD = 'https://paygreen.fr';

    public function __construct()
    {
        $environment = new Environment(
            getenv('PAYGREEN_PUBLIC_KEY'),
            getenv('PAYGREEN_PRIVATE_KEY'),
            getenv('PAYGREEN_API_SERVER')
        );

        parent::__construct($environment);

        $this->initClient();
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
        $this->client = new Client(array(
            'base_uri' => $this->getBaseUri(),
            'defaults' => array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => $this->buildUserAgentHeader()
                )
            )
        ));
    }
}