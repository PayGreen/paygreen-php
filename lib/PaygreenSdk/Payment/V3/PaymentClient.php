<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Core\Response\JsonResponse;
use Paygreen\Sdk\Payment\Client;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Request\Authentication\AuthenticationRequest;
use Paygreen\Sdk\Payment\V3\Request\Buyer\BuyerRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentOrder\OrderRequest;

class PaymentClient extends Client
{
    /**
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function authenticate()
    {
        $request = (new AuthenticationRequest($this->requestFactory, $this->environment))->getRequest();
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function createBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getCreateRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function getBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getGetRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function updateBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getUpdateRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function createOrder(PaymentOrder $paymentOrder)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @param int $paymentReference
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function getOrder($paymentReference)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getGetRequest($paymentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @throws Exception|\Http\Client\Exception
     *
     * @return JsonResponse
     */
    public function updateOrder(PaymentOrder $paymentOrder)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getUpdateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }
}
