<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Exception;
use Paygreen\Sdk\Climate\V2\Enum\FootprintStatusEnum;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;


class FootprintRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $footprintId
     *
     * @return RequestInterface
     */
    public function getCreateRequest($footprintId)
    {
        $body = [
            'idFootprint' => $footprintId,
        ];

        return $this->requestFactory->create(
            '/carbon/footprints',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param bool $detailed
     *
     * @return RequestInterface
     */
    public function getGetRequest($footprintId, $detailed = false)
    {
        $detailed = ($detailed) ? 1 : 0;

        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '?detailed=' . urlencode($detailed),
            null,
            'GET'
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param string $status
     *
     * @return RequestInterface
     */
    public function getCloseRequest($footprintId, $status)
    {
        $body = [
            'status' => $status
        ];

        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'PATCH'
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param int $amount
     *
     * @return RequestInterface
     */
    public function getUserContributedRequest($footprintId, $amount)
    {
        $body = [
            'status' => FootprintStatusEnum::USER_CONTRIBUTED,
            'userContribution' => $amount
        ];
        
        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId),
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'PATCH'
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param WebBrowsingData $webBrowsingData
     *
     * @throws Exception
     * 
     * @return RequestInterface
     */
    public function getAddWebBrowsingDataRequest($footprintId, WebBrowsingData $webBrowsingData)
    {
        $body = [
            'userAgent' => $webBrowsingData->getUserAgent(),
            'device' => $webBrowsingData->getDevice(),
            'browser' => $webBrowsingData->getBrowser(),
            'countImages' => $webBrowsingData->getImageCount(),
            'countPages' => $webBrowsingData->getPageCount(),
            'time' => $webBrowsingData->getTime(),
            'externalId' => $webBrowsingData->getExternalId()
        ];

        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '/web',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param DeliveryData $deliveryData
     *
     * @throws Exception
     * 
     * @return RequestInterface
     */
    public function getAddDeliveryDataRequest($footprintId, DeliveryData $deliveryData)
    {
        $body = [
            'totalWeightInKg' => $deliveryData->getTotalWeightInKg(),
            'departure' => [
                'address' => $deliveryData->getShippedFrom()->getAddress(),
                'zipCode' => $deliveryData->getShippedFrom()->getZipCode(),
                'city' => $deliveryData->getShippedFrom()->getCity(),
                'country' => $deliveryData->getShippedFrom()->getCountry(),
            ],
            'arrival' => [
                'address' => $deliveryData->getShippedTo()->getAddress(),
                'zipCode' => $deliveryData->getShippedTo()->getZipCode(),
                'city' => $deliveryData->getShippedTo()->getCity(),
                'country' => $deliveryData->getShippedTo()->getCountry(),
            ],
            'transportationExternalId' => $deliveryData->getTransportationExternalId(),
            'deliveryService' => $deliveryData->getDeliveryService()
        ];

        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '/delivery',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->withTestMode()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     *
     * @throws Exception
     * 
     * @return RequestInterface
     */
    public function getDeleteDeliveryDataRequest($footprintId)
    {
        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '/delivery',
            null,
            'DELETE'
        )->withAuthorization()->withTestMode()->getRequest();
    }

    /**
     * @param string $footprintId
     *
     * @throws Exception
     *
     * @return RequestInterface
     */
    public function getReserveCarbonRequest($footprintId)
    {
        return $this->requestFactory->create(
            '/carbon/footprints/' . urlencode($footprintId) . '/contribution'
        )->withAuthorization()->withTestMode()->getRequest();
    }
}