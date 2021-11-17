<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Core\Response\JsonResponse;
use Paygreen\Sdk\Payment\Client;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Request\Authentication\AuthenticationRequest;
use Paygreen\Sdk\Payment\V3\Request\Buyer\BuyerRequest;

class PaymentClient extends Client
{
    /**
     * @return JsonResponse
     * @throws Exception|\Http\Client\Exception
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
     * @return JsonResponse
     * @throws Exception|\Http\Client\Exception
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
     * @return JsonResponse
     * @throws Exception|\Http\Client\Exception
     */
    public function getBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getGetRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return new JsonResponse($response);
    }
}