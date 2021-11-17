<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Psr\Http\Message\RequestInterface;

class CreateCashRequest extends \Paygreen\Sdk\Core\Request\Request
{    
    /** @var PaymentOrder */
    private $paymentOrder;

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
        $this->paymentOrder = $paymentOrder;
        
        parent::__construct($requestFactory, $environment);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/$publicKey/payins/transaction/cash",
            $this->paymentOrder->serialize()
        );
    }
}