<?php

namespace Paygreen\Sdk\Payment\V2;

use Exception;
use Http\Client\Exception as HttpClientException;
use Paygreen\Sdk\Core\Response\JsonResponse;
use Paygreen\Sdk\Payment\Client;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CreateCashRequest;

class PaymentClient extends Client
{
    /**
     * @param PaymentOrder $paymentOrder
     * @return JsonResponse
     * @throws HttpClientException
     * @throws Exception
     */
    public function createCashPayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();
        
        $this->logger->info("Create '$paymentType' cash payment with an amount of '$amount'.");
        
        $request = (new CreateCashRequest($this->requestFactory, $this->environment))->getRequest($paymentOrder);
        
        $this->setLastRequest($request);
        
        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if ($response->getStatusCode() === 200) {
            $this->logger->info('Cash payment successfully created.');
        }

        return new JsonResponse($response);
    }
}