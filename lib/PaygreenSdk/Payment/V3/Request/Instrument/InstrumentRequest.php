<?php

namespace Paygreen\Sdk\Payment\V3\Request\Instrument;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Psr\Http\Message\RequestInterface;

class InstrumentRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $reference
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getGetRequest($reference)
    {
        return $this->requestFactory->create(
            "/payment/instruments/{$reference}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param Instrument $instrument
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getCreateRequest($instrument)
    {
        $body = [
            'token' => $instrument->getToken(),
            'type' => $instrument->getType(),
            'with_authorization' => $instrument->isWithAuthorization()
        ];

        return $this->requestFactory->create(
            "/payment/instruments",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param Instrument $instrument
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getUpdateRequest($instrument)
    {
        $body = [
            'token' => $instrument->getToken(),
            'type' => $instrument->getType(),
            'with_authorization' => $instrument->isWithAuthorization()
        ];

        $reference = $instrument->getReference();

        return $this->requestFactory->create(
            "/payment/instruments/{$reference}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $reference
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getDeleteRequest($reference)
    {
        return $this->requestFactory->create(
            "/payment/instruments/{$reference}",
            null,
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string|null $buyerId
     * @throws Exception
     *
     * @return Request|RequestInterface
     */
    public function getListRequest($buyerId = null)
    {
        $buyerIdRequestParameter = "";
        if (null !== $buyerId){
            $buyerIdRequestParameter = "?buyer_id=".$buyerId;
        }

        return $this->requestFactory->create(
            "/payment/instruments{$buyerIdRequestParameter}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}
