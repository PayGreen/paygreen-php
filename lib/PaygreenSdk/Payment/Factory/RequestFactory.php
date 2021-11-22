<?php

namespace Paygreen\Sdk\Payment\Factory;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Environment;
use Psr\Http\Message\StreamInterface;

class RequestFactory
{

    /** @var Environment */
    private $environment;
    
    /** @var Request */
    public $request;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param string $url
     * @param string|resource|StreamInterface|null $body
     * @param string $method
     * @param bool $withBearer
     * @return Request
     */
    public function create(
        $url,
        $body = null,
        $method = 'POST',
        $withBearer = true
    ) {
        $url = $this->environment->getEndpoint() . $url;

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => '0',
            'Accept' => 'application/json',
            'User-Agent' => $this->buildUserAgentHeader()
        ];

        if ($withBearer) {
            $headers['Authorization'] = 'Bearer ' . $this->environment->getBearer();
        }

        return $this->request = new Request($method, $url, $headers, $body);
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