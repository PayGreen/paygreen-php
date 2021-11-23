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
     * @return RequestFactory
     */
    public function create(
        $url,
        $body = null,
        $method = 'POST'
    ) {
        $url = $this->environment->getEndpoint() . $url;

        $header = [
            'User-Agent' => $this->buildUserAgentHeader()
        ];

        $this->request = new Request($method, $url, $header, $body);

        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @return RequestFactory
     */
    public function withAuthorization() {
        $this->request = $this->request->withAddedHeader(
            'Authorization',
            'Bearer ' . $this->environment->getBearer()
        );

        return $this;
    }

    /**
     * @return RequestFactory
     */
    public function isJson() {

        $size = 0;
        $body = $this->request->getBody();
        if ($body !== null) {
           $size = (string)$body->getSize();
        }

        $this->request = $this->request->withAddedHeader('Content-Type', 'application/json');
        $this->request = $this->request->withAddedHeader('Accept', 'application/json');
        $this->request = $this->request->withAddedHeader('Content-Length', $size);

        return $this;
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