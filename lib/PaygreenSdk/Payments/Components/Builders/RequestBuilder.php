<?php

namespace Paygreen\Sdk\Payments\Components\Builders;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Components\Config;
use Paygreen\Sdk\Payments\Exceptions\InvalidApiVersion;
use Psr\Http\Message\RequestInterface;

class RequestBuilder
{
    /** @var array */
    private $config = [];

    /** @var string */
    private $privateKey;

    /** @var string */
    private $baseUri;

    /**
     * @param int $apiVersion
     * @param string $privateKey
     * @throws InvalidApiVersion
     */
    public function __construct($apiVersion, $privateKey, $baseUri)
    {
        $this->loadRequestsConfig($apiVersion);
        $this->privateKey = $privateKey;
        $this->baseUri = $baseUri;
    }

    /**
     * @param string $name
     * @param array $options
     * @param array $body
     * @param bool $private
     * @return RequestInterface
     */
    public function buildRequest(
        $name,
        array $options = [],
        array $body = [],
        $private = true
    ) {
        $requestConfig = $this->config[$name];

        $url = $this->baseUri . $this->parseUrlParameters($requestConfig['url'], $options);

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => $this->buildUserAgentHeader()
        ];

        if ($private) {
            $headers['Authorization'] = 'Bearer ' . $this->privateKey;
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
                    throw new \LogicException("Unable to retrieve parameter : '$key'.");
                }

                $url = preg_replace('/{' . $key . '}/i', $parameters[$key], $url);
            }
        }

        return $url;
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
     * @throws InvalidApiVersion
     */
    private function loadRequestsConfig($apiVersion)
    {
        $config = new Config();

        switch ($apiVersion) {
            case 2:
                $this->config = $config['payment.v2.requests'];
                break;
            case 3:
                $this->config = $config['payment.v3.requests'];
                break;
            default:
                throw new InvalidApiVersion("Invalid API version. Value should be '2' or '3'.");
        }
    }
}