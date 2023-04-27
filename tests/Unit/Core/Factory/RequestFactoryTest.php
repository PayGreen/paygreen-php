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
        parent::setUp();

        $this->environment = $this->getMockBuilder(Environment::class)->setConstructorArgs([
            'public_key',
            'private_key',
            'sandbox',
            3
        ])->getMock();
    }
    public function testCreateRequest()
    {
        $this->buildRequestFactory();
        $this->assertInstanceOf(RequestFactory::class, $this->requestFactory);

        $request = $this->requestFactory->create(
            '/api/v3/transactions',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize(
                ['body' => 'content'],
                'json'
            ),
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
        $this->buildRequestFactory();

        $isPhpMajorVersionDefined = defined('PHP_MAJOR_VERSION');
        $isPhpMinorVersionDefined = defined('PHP_MINOR_VERSION');
        $isPhpReleaseVersionDefined = defined('PHP_RELEASE_VERSION');

        if ($isPhpMajorVersionDefined && $isPhpMinorVersionDefined && $isPhpReleaseVersionDefined) {
            $phpVersion = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION;
        } else {
            $phpVersion = phpversion();
        }

        $this->environment->method('getSdkVersion')->willReturn('1.3.6');
        $this->environment->method('getApiName')->willReturn('payment');
        $this->environment->method('getApiVersion')->willReturn('3');

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "PGSDK - sdk:1.3.6 api:payment:3 php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );

        $this->environment->method('getApplicationName')->willReturn('prestashop-payment');

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "PGSDK - application:prestashop-payment sdk:1.3.6 api:payment:3 php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );

        $this->environment->method('getApplicationVersion')->willReturn('1.0.0');

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "PGSDK - application:prestashop-payment:1.0.0 " .
            "sdk:1.3.6 api:payment:3 php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );

        $this->environment->method('getCmsName')->willReturn('prestashop');
        $this->environment->method('getCmsVersion')->willReturn('1.7');

        $request = $this->requestFactory->create('/api/v3/transactions')->getRequest();
        $this->assertEquals(
            "PGSDK - application:prestashop-payment:1.0.0 cms:prestashop:1.7 " .
            "sdk:1.3.6 api:payment:3 php:$phpVersion;",
            $request->getHeader('User-Agent')[0]
        );
    }

    private function buildRequestFactory()
    {
        $this->requestFactory = new RequestFactory($this->environment);
    }
}