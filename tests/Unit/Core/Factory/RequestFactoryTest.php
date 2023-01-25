<?php

namespace Paygreen\Tests\Unit\Core\Factory;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\EnvironmentInterface;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Environment;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

final class RequestFactoryTest extends TestCase
{
    /**
     * @return RequestFactory
     */
    private $requestFactory;

    /**
     * @return EnvironmentInterface
     */
    private $environment;

    public function setUp()
    {
        $this->environment = new Environment(
            'public_key',
            'private_key',
            'sandbox',
            2
        );
    }
    public function testCreateRequest()
    {
        $this->buildRequestFactory();
        $this->assertInstanceOf(RequestFactory::class, $this->requestFactory);

        $body = ['body' => 'content'];

        $request = $this->requestFactory->create(
            '/api/v3/transactions',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'POST',
            ['Content-Type' => 'application/json']
        )->getRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals('/api/v3/transactions', $request->getUri()->getPath());
        $this->assertEquals('content', $content->body);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('application/json', $request->getHeader('Content-Type')[0]);
    }

    public function testBuildUserAgentHeader()
    {
        $isPhpMajorVersionDefined = defined('PHP_MAJOR_VERSION');
        $isPhpMinorVersionDefined = defined('PHP_MINOR_VERSION');
        $isPhpReleaseVersionDefined = defined('PHP_RELEASE_VERSION');

        if ($isPhpMajorVersionDefined && $isPhpMinorVersionDefined && $isPhpReleaseVersionDefined) {
            $phpVersion = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION;
        } else {
            $phpVersion = phpversion();
        }

        $sdkVersion = \Composer\InstalledVersions::getPrettyVersion('paygreen/paygreen-php');

        $this->buildRequestFactory();

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "sdk:$sdkVersion php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );

        $this->environment->setApplicationName('prestashop-payment');
        $this->environment->setApplicationVersion('1.0.0');
        $this->environment->setCmsName('prestashop');
        $this->environment->setCmsVersion('1.7');
        $this->buildRequestFactory();

        $this->buildRequestFactory();
        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "application:prestashop-payment:1.0.0 cms:prestashop:1.7 sdk:$sdkVersion php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );

        $this->environment->setApplicationName('');
        $this->environment->setApplicationVersion('');
        $this->environment->setCmsName('prestashop');
        $this->environment->setCmsVersion('1.7');
        $this->buildRequestFactory();

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "cms:prestashop:1.7 sdk:$sdkVersion php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );

        $this->environment->setApplicationName('prestashop-payment');
        $this->environment->setApplicationVersion('1.0.0');
        $this->environment->setCmsName('prestashop');
        $this->environment->setCmsVersion('');
        $this->buildRequestFactory();

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "application:prestashop-payment:1.0.0 sdk:$sdkVersion php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );
    }

    private function buildRequestFactory()
    {
        $this->requestFactory = new RequestFactory($this->environment);
    }
}