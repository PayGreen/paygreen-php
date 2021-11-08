<?php

namespace Paygreen\Sdk\Payment\Component\Builder;

use Exception;
use LogicException;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Component\Config;
use Paygreen\Sdk\Core\Component\Environment;
use Paygreen\Sdk\Payment\Exception\InvalidApiVersionException;
use Psr\Http\Message\RequestInterface;

class RequestBuilder
{
    /** @var array */
    private $config = [];

    /** @var Environment */
    private $environment;

    /** @var string */
    private $baseUri;

    /**
     * @param Environment $environment
     * @throws InvalidApiVersionException
     */
    public function __construct(Environment $environment)
    {
        $this->loadConfig($environment->getApiVersion());
        $this->environment = $environment;
        $this->baseUri = $this->getBaseUri();
    }

    /**
     * @param string $name
     * @param array $options
     * @param array $body
     * @return RequestInterface
     * @throws Exception
     */
    public function buildRequest(
        $name,
        array $options = [],
        array $body = []
    ) {
        $requestConfig = $this->config['requests'][$name];

        if ($requestConfig === null) {
           throw new Exception("Request config '$name' not found.");
        }

        $url = $this->baseUri . $this->parseUrlParameters($requestConfig['url'], $options);

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => $this->buildUserAgentHeader()
        ];

        if ($requestConfig['private']) {
            $headers['Authorization'] = 'Bearer ' . $this->environment->getPrivateKey();
        }

        foreach ($body as $key => $item) {
            if (empty($item)) {
                unset($body[$key]);
            }
        }

        $body = json_encode($body);

        return new Request($requestConfig['method'], $url, $headers, $body);
    }

    /**
     * @param string $url
     * @param array $parameters
     * @return string
     */
    private function parseUrlParameters($url, array $parameters)
    {
        if (preg_match_all('/({(?<keys>[A-Z-_]+)})/i', $url, $results)) {
            foreach ($results['keys'] as $key) {
                if (!array_key_exists($key, $parameters)) {
                    throw new LogicException("Unable to retrieve parameter : '$key'.");
                }

                $url = preg_replace('/{' . $key . '}/i', $parameters[$key], $url);
            }
        }

        return $url;
    }

    /**
     * @return string
     */
    private function getBaseUri()
    {
        if ($this->environment->getEnvironment() === 'SANDBOX') {
            $baseUri = $this->config['servers']['SANDBOX'];
        } else {
            $baseUri = $this->config['servers']['PROD'];
        }

        return $baseUri;
    }

    /**
     * @return string
     */
    private function buildUserAgentHeader()
    {
        $isPhpMajorVersionDefined = defined('PHP_MAJOR_VERSION');
        $isPhpMinorVersionDefined = defined('PHP_MINOR_VERSION');
        $isPhpReleaseVersionDefined = defined('PHP_RELEASE_VERSION');

        if ($isPhpMajorVersionDefined && $isPhpMinorVersionDefined && $isPhpReleaseVersionDefined) {
            $phpVersion = PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION;
        } else {
            $phpVersion = phpversion();
        }

        return "PayGreenSDK/1.0.0 php:$phpVersion;";
    }

    /**
     * @param int $apiVersion
     * @return void
     * @throws InvalidApiVersionException
     */
    private function loadConfig($apiVersion)
    {
        $config = new Config();

        switch ($apiVersion) {
            case 2:
                $this->config['requests'] = $config['payment.v2.requests'];
                $this->config['servers'] = $config['payment.v2.servers'];
                break;
            case 3:
                $this->config['requests'] = $config['payment.v3.requests'];
                $this->config['servers'] = $config['payment.v3.servers'];
                break;
            default:
                throw new InvalidApiVersionException("Invalid API version. Value should be '2' or '3'.");
        }
    }
}