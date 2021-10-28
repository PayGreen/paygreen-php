<?php

namespace PayGreenSdk\Core;


use GuzzleHttp\Client;
use PayGreenSdk\Core\Components\Environment;

class HttpClient
{
    /** @var Client */
    protected $client;

    /** @var Environment */
    protected $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    protected function buildUserAgentHeader()
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
     * @param string $url
     * @return string
     */
    protected function parseUrl($url, $parameters)
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
}