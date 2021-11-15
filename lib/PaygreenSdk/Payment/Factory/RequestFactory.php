<?php

namespace Paygreen\Sdk\Payment\Factory;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Environment;

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
     * @param array<string> $body
     * @param string $method
     * @param bool $withBearer
     * @return Request
     */
    public function create(
        $url,
        array $body = [],
        $method = 'POST',
        $withBearer = true
    ) {
        $url = $this->environment->getEndpoint() . $url;

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => $this->buildUserAgentHeader()
        ];

        if ($withBearer) {
            $headers['Authorization'] = 'Bearer ' . $this->environment->getBearer();
        }

        foreach ($body as $key => $item) {
            if (empty($item)) {
                unset($body[$key]);
            }
        }

        $body = json_encode($body);

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