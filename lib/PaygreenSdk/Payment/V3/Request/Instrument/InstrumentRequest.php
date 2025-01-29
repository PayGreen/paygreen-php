<?php

namespace Paygreen\Sdk\Payment\V3\Request\Instrument;

use Exception;
use GuzzleHttp\Psr7\Request;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\InstrumentInterface;
use Psr\Http\Message\RequestInterface;

class InstrumentRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $instrumentId
     * @return Request|RequestInterface
     * @throws Exception
     *
     */
    public function getGetRequest($instrumentId)
    {
        return $this->requestFactory->create(
            '/payment/instruments/' . urlencode($instrumentId),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @return Request|RequestInterface
     * @throws Exception
     *
     */
    public function getListRequest($filters = [], $pagination = [])
    {
        return $this->requestFactory->create(
            '/payment/instruments?' . $this->getListParameters($filters, $pagination),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param InstrumentInterface $instrument
     * @return Request|RequestInterface
     * @throws Exception
     *
     */
    public function getCreateRequest(InstrumentInterface $instrument)
    {
        $buyer = null;

        if ($instrument->getBuyer()) {
            if (null === $instrument->getBuyer()->getId()) {
                $buyer = [
                    'email' => $instrument->getBuyer()->getEmail(),
                    'first_name' => $instrument->getBuyer()->getFirstName(),
                    'last_name' => $instrument->getBuyer()->getLastName(),
                    'reference' => $instrument->getBuyer()->getReference(),
                    'phone_number' => $instrument->getBuyer()->getPhoneNumber()
                ];
            } else {
                $buyer = $instrument->getBuyer()->getId();
            }
        }

        $body = [
            'token' => $instrument->getToken(),
            'type' => $instrument->getType(),
            'with_authorization' => $instrument->isWithAuthorization(),
            'reuse_allowed' => $instrument->isReuseAllowed(),
            'buyer' => $buyer,
        ];

        return $this->requestFactory->create(
            '/payment/instruments',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param InstrumentInterface $instrument
     * @return Request|RequestInterface
     * @throws Exception
     *
     */
    public function getUpdateRequest(InstrumentInterface $instrument)
    {
        $body = [
            'token' => $instrument->getToken(),
            'type' => $instrument->getType(),
            'with_authorization' => $instrument->isWithAuthorization()
        ];

        $reference = $instrument->getReference();

        return $this->requestFactory->create(
            '/payment/instruments/' . urlencode($reference),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $reference
     * @return Request|RequestInterface
     * @throws Exception
     *
     */
    public function getDeleteRequest($reference)
    {
        return $this->requestFactory->create(
            '/payment/instruments/' . urlencode($reference),
            null,
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }
}
