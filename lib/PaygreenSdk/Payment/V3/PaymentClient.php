<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Request\Authentication\AuthenticationRequest;
use Paygreen\Sdk\Payment\V3\Request\Buyer\BuyerRequest;
use Paygreen\Sdk\Payment\V3\Request\Instrument\InstrumentRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentOrder\OrderRequest;
use Psr\Http\Message\ResponseInterface;

class PaymentClient extends \Paygreen\Sdk\Core\PaymentClient
{
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
     * @param int $paymentReference
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
     * @param int $instrumentReference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function deleteInstrument($instrumentReference)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getDeleteRequest($instrumentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param int $paymentReference
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
     * @param int $paymentReference
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
}
