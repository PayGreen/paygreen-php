<?php

namespace Paygreen\Sdk\Payment\V2;

use Exception;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\Request\OAuthRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CancelRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\CashRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\RecurringRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\RefundRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\TokenizeRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\TransactionRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentOrder\XtimeRequest;
use Paygreen\Sdk\Payment\V2\Request\PaymentTypeRequest;
use Paygreen\Sdk\Payment\V2\Request\ShopRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class Client extends \Paygreen\Sdk\Core\Client
{
    /** @var RequestFactory */
    protected $requestFactory;

    /** @var Environment */
    protected $environment;

    public function __construct(
        $client,
        Environment $environment,
        LoggerInterface $logger = null
    ) {
        $this->environment = $environment;
        $this->requestFactory = new RequestFactory($this->environment);

        parent::__construct($client, $logger);
    }
    
    /**
     * @param string      $ipAddress
     * @param string      $email
     * @param string      $name
     * @param null|string $phoneNumber
     * @param null|string $serverAddress
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createOAuthAccessToken(
        $ipAddress,
        $email,
        $name,
        $phoneNumber = null,
        $serverAddress = null
    ) {
        $this->logger->info('Create OAuth access token.');

        $request = (new OAuthRequest($this->requestFactory, $this->environment))->getCreateTokenRequest(
            $ipAddress,
            $email,
            $name,
            $phoneNumber,
            $serverAddress
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('OAuth access token successfully created.');
        }

        return $response;
    }

    /**
     * @param string $clientId
     * @param string $redirectUri
     * @param string $responseType
     *
     * @throws Exception
     *
     * @return string
     */
    public function getOAuthAuthenticationPage($clientId, $redirectUri, $responseType = 'code')
    {
        $this->logger->info('Get OAuth authentication page.');

        return (new OAuthRequest($this->requestFactory, $this->environment))->getAuthenticationPageRequest(
            $clientId,
            $redirectUri,
            $responseType
        );
    }

    /**
     * @param string $clientId
     * @param string $code
     * @param string $grantType
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function controlOAuthAuthentication($clientId, $code, $grantType = 'authorization_code')
    {
        $this->logger->info('Control OAuth authentication.');

        $request = (new OAuthRequest($this->requestFactory, $this->environment))->getAuthenticationControlRequest(
            $clientId,
            $grantType,
            $code
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('OAuth authentication is valid.');
        }

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getShop()
    {
        $this->logger->info('Get shop config.');

        $request = (new ShopRequest($this->requestFactory, $this->environment))->getGetRequest();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Shop config successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws Exception
     *
     * @return ResponseInterface
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

        return $response;
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws Exception
     *
     * @return ResponseInterface
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

        return $response;
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws Exception
     *
     * @return ResponseInterface
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

        return $response;
    }

    /**
     * @param PaymentOrder $paymentOrder
     *
     * @throws Exception
     *
     * @return ResponseInterface
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

        return $response;
    }

    /**
     * @param string $transactionId
     *
     * @throws Exception
     *
     * @return ResponseInterface
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

        return $response;
    }

    /**
     * @param string   $transactionId
     * @param null|int $amount
     *
     * @throws Exception
     *
     * @return ResponseInterface
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

        return $response;
    }

    /**
     * @param string $transactionId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getTransaction($transactionId)
    {
        $this->logger->info("Fetch transaction '{$transactionId}'.");

        $request = (new TransactionRequest($this->requestFactory, $this->environment))->getGetRequest($transactionId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Transaction successfully retrieved.');
        }

        return $response;
    }

    /**
     * Useful to confirm tokenize transaction.
     *
     * @param string $transactionId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function confirmTransaction($transactionId)
    {
        $this->logger->info("Confirm transaction '{$transactionId}'.");

        $request = (new TransactionRequest($this->requestFactory, $this->environment))->getConfirmationRequest(
            $transactionId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Transaction successfully confirmed.');
        }

        return $response;
    }

    /**
     * @param string $transactionId
     * @param int    $amount
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateTransactionAmount($transactionId, $amount)
    {
        $this->logger->info("Update transaction amount '{$transactionId}' with an amount of '{$amount}'.");

        $request = (new TransactionRequest($this->requestFactory, $this->environment))->getUpdateAmountRequest(
            $transactionId,
            $amount
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Transaction amount successfully updated.');
        }

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getAvailablePaymentType()
    {
        $this->logger->info('Fetch available payment type.');

        $request = (new PaymentTypeRequest($this->requestFactory, $this->environment))->getGetRequest();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Available payment successfully retrieved.');
        }

        return $response;
    }
}
