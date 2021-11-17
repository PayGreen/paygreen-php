<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class CreateCashRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param RequestFactory $requestFactory
     * @param Environment $environment
     * @throws Exception
     */
    public function __construct(
        $requestFactory,
        $environment
    ) {
        
        parent::__construct($requestFactory, $environment);
    }

    /**
     * @param PaymentOrder $paymentOrder
     * @return RequestInterface
     */
    public function getRequest($paymentOrder)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/$publicKey/payins/transaction/cash",
            $paymentOrder->serialize()
        );
    }
}