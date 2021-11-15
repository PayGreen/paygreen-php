<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class CreateRequest
{
    /**
     * @var Request|RequestInterface
     */
    private $request;

    /**
     * @param RequestFactory $requestFactory
     * @param Environment $environment
     * @param PaymentOrder $paymentOrder
     * @throws Exception
     */
    public function __construct(
        $requestFactory,
        $environment,
        $paymentOrder
    ) {
        $publicKey = $environment->getPublicKey();
        
        $this->request = $requestFactory->create(
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