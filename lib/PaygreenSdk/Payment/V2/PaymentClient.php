<?php

namespace Paygreen\Sdk\Payment\V2;

use Exception;
use Paygreen\Sdk\Payment\Client;
use Paygreen\Sdk\Payment\Component\Response\Response;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CreateRequest;

class PaymentClient extends Client
{
    /**
     * @param PaymentOrder $paymentOrder
     * @return Response
     * @throws Exception
     */
    public function createPaymentOrder($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();
        $this->logger->info("Create '$paymentType' cash payment with an amount of '$amount'.");
        
        $request = new CreateRequest($this->requestBuilder, $this->environment, $paymentOrder);
        
        $response = $this->sendRequest($request->getRequest());

        if ($response->getHttpCode() === 200) {
            $this->logger->info('Cash payment successfully created.');
        }
        return $response;
    }
}