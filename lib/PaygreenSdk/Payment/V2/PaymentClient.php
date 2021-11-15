<?php

namespace Paygreen\Sdk\Payment\V2;

use Exception;
use Paygreen\Sdk\Core\Response\JsonResponse;
use Paygreen\Sdk\Payment\Client;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CreateRequest;

class PaymentClient extends Client
{
    /**
     * @param PaymentOrder $paymentOrder
     * @return JsonResponse
     * @throws Exception
     */
    public function createPaymentOrder($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();
        $this->logger->info("Create '$paymentType' cash payment with an amount of '$amount'.");
        
        $request = new CreateRequest($this->requestFactory, $this->environment, $paymentOrder);
        
        $response = $this->sendRequest($request->getRequest());

        if ($response->getStatusCode() === 200) {
            $this->logger->info('Cash payment successfully created.');
        }

        return new JsonResponse($response);
    }
}