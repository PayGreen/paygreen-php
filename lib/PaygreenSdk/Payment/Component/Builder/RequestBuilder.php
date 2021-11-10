<?php

namespace Paygreen\Sdk\Payment\Component\Builder;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Component\Environment;

class RequestBuilder
{

    /** @var Environment */
    private $environment;

    /** @var string */
    private $baseUri;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
        $this->baseUri = $this->getBaseUri();
    }

    /**
     * @param string $url
     * @param array<string> $body
     * @param string $method
     * @param bool $withBearer
     * @return Request
     */
    public function buildRequest(
        $url,
        array $body = [],
        $method = 'POST',
        $withBearer = true
    ) {
        $url = $this->baseUri . $url;

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => $this->buildUserAgentHeader()
        ];

        if ($withBearer) {
            $headers['Authorization'] = 'Bearer ' . $this->environment->getPrivateKey();
        }

        foreach ($body as $key => $item) {
            if (empty($item)) {
                unset($body[$key]);
            }
        }

        $body = json_encode($body);

        return new Request($method, $url, $headers, $body);
    }

    /**
     * @return string
     */
    private function getBaseUri()
    {
        if ($this->environment->getEnvironment() === 'SANDBOX') {
            $baseUri = "https://sandbox.paygreen.fr"; // TODO
        } else {
            $baseUri = "https://paygreen.fr"; // TODO
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
}