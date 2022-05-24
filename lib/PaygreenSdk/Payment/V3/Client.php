<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Request\Authentication\AuthenticationRequest;
use Paygreen\Sdk\Payment\V3\Request\Buyer\BuyerRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentConfig\PaymentConfigRequest;
use Paygreen\Sdk\Payment\V3\Request\Instrument\InstrumentRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentOrder\OrderRequest;
use Paygreen\Sdk\Payment\V3\Request\PublicKey\PublicKeyRequest;
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
     * @throws Exception
     *
     *@return ResponseInterface
     */
    public function authenticate()
    {
        $request = (new AuthenticationRequest($this->requestFactory, $this->environment))->getRequest();
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     *@return ResponseInterface
     */
    public function listPaymentConfig()
    {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))->getGetRequest();
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     *@return ResponseInterface
     */
    public function getPublicKey($publicKey)
    {
        $request = (new PublicKeyRequest($this->requestFactory, $this->environment))->getGetRequest($publicKey);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getCreateRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getGetRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getUpdateRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createOrder(PaymentOrder $paymentOrder)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentReference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getOrder($paymentReference)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getGetRequest($paymentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateOrder(PaymentOrder $paymentOrder)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getUpdateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentReference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function captureOrder($paymentReference)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getCaptureRequest($paymentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentReference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function refundOrder($paymentReference)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getRefundRequest($paymentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $reference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function deleteInstrument($reference)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getDeleteRequest($reference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param Instrument $instrument
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createInstrument($instrument)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getCreateRequest($instrument);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param Instrument $instrument
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateInstrument($instrument)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getUpdateRequest($instrument);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $reference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getInstrument($reference)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getGetRequest($reference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }
}
