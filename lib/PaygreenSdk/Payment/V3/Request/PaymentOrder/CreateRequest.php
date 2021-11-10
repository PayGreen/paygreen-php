<?php

namespace Paygreen\Sdk\Payment\V3\Request\PaymentOrder;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Component\Environment;
use Paygreen\Sdk\Payment\Component\Builder\RequestBuilder;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class CreateRequest
{
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @var Request|RequestInterface
     */
    private $request;

    /**
     * @param RequestBuilder $requestBuilder
     * @param Environment $environment
     * @param PaymentOrder $paymentOrder
     * @throws Exception
     */
    public function __construct(
        $requestBuilder,
        $environment,
        $paymentOrder
    ) {
        $this->requestBuilder = $requestBuilder;

        $this->request = $this->requestBuilder->buildRequest(
            'create_cash',
            [
                'ui' => $environment->getPublicKey()
            ],
            $paymentOrder->serialize()
        );
    }

    /**
     * @return Request|RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}