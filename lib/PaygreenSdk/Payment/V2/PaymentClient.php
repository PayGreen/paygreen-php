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
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\TokenizeRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\XtimeRequest;

class PaymentClient extends Client
{
    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws HttpClientException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function createCashPayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();

        $this->logger->info("Create '{$paymentType}' cash payment with an amount of '{$amount}'.");

        $request = (new CashRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Cash payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws HttpClientException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function createRecurringPayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();

        $this->logger->info("Create '{$paymentType}' recurring payment with an amount of '{$amount}'.");

        $request = (new RecurringRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Recurring payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws HttpClientException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function createXtimePayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();

        $this->logger->info("Create '{$paymentType}' XTIME payment with an amount of '{$amount}'.");

        $request = (new XtimeRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('XTIME payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws HttpClientException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function createTokenizePayment($paymentOrder)
    {
        $paymentType = $paymentOrder->getPaymentType();
        $amount = $paymentOrder->getOrder()->getAmount();

        $this->logger->info("Create '{$paymentType}' tokenize payment with an amount of '{$amount}'.");

        $request = (new TokenizeRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Tokenize payment successfully created.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param string $transactionId
     *
     * @throws HttpClientException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function cancelPayment($transactionId)
    {
        $this->logger->info("Cancelling payment with transaction id '{$transactionId}'.");

        $request = (new CancelRequest($this->requestFactory, $this->environment))->getCancelRequest(
            $transactionId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Payment successfully canceled.');
        }

        return new JsonResponse($response);
    }

    /**
     * @param string   $transactionId
     * @param null|int $amount
     *
     * @throws HttpClientException
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function refundPayment($transactionId, $amount = null)
    {
        $this->logger->info("Refund transaction '{$transactionId}' with amount '{$amount}'.");

        $request = (new RefundRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $transactionId,
            $amount
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Refund successfully executed.');
        }

        return new JsonResponse($response);
    }
}
