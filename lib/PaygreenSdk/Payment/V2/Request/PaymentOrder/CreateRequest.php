<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Component\Environment;
use Paygreen\Sdk\Payment\Component\Builder\RequestBuilder;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class CreateRequest
{
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
        $publicKey = $environment->getPublicKey();
        
        $this->request = $requestBuilder->buildRequest(
            "/api/$publicKey/payins/transaction/cash",
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