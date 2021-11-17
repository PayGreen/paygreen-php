<?php

namespace Paygreen\Sdk\Payment\V3\Request\Buyer;

use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Psr\Http\Message\RequestInterface;

class BuyerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @return Request|RequestInterface
     */
    public function getCreateRequest(Buyer $buyer)
    {
        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/payment/shops/$publicKey/buyers",
            $buyer->serialize()
        );
    }
}