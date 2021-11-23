<?php

namespace Paygreen\Sdk\Payment\V2;

use Exception;
use Http\Client\Exception as HttpClientException;
use Paygreen\Sdk\Core\Response\JsonResponse;
use Paygreen\Sdk\Payment\Client;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CancelRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CashRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\RecurringRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\RefundRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\XtimeRequest;

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
        
        $request = (new CashRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);
        
        $this->setLastRequest($request);
        
        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if ($response->getStatusCode() === 200) {
            $this->logger->info('Cash payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param PaymentOrder $paymentOrder
     * @return JsonResponse
     * @throws HttpClientException
     * @throws Exception
     */
    public function createRecurringPayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();

        $this->logger->info("Create '$paymentType' recurring payment with an amount of '$amount'.");

        $request = (new RecurringRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if ($response->getStatusCode() === 200) {
            $this->logger->info('Recurring payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param PaymentOrder $paymentOrder
     * @return JsonResponse
     * @throws HttpClientException
     * @throws Exception
     */
    public function createXtimePayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();

        $this->logger->info("Create '$paymentType' XTIME payment with an amount of '$amount'.");

        $request = (new XtimeRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if ($response->getStatusCode() === 200) {
            $this->logger->info('XTIME payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param string $transactionId
     * @return JsonResponse
     * @throws HttpClientException
     * @throws Exception
     */
    public function cancelPayment($transactionId)
    {
        $this->logger->info("Cancelling payment with transaction id '$transactionId'.");

        $request = (new CancelRequest($this->requestFactory, $this->environment))->getCancelRequest(
            $transactionId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if ($response->getStatusCode() === 200) {
            $this->logger->info('Payment successfully canceled.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param string $transactionId
     * @param int|null $amount
     * @return JsonResponse
     * @throws HttpClientException
     * @throws Exception
     */
    public function refundPayment($transactionId, $amount = null)
    {
        $this->logger->info("Refund transaction '$transactionId' with amount '$amount'.");

        $request = (new RefundRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $transactionId, $amount
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if ($response->getStatusCode() === 200) {
            $this->logger->info('Refund successfully executed.');
        }

        return new JsonResponse($response);
    }
}