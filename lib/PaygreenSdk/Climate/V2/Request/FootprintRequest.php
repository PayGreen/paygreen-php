<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Exception;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class FootprintRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $footprintId
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getCreateRequest($footprintId)
    {
        $violations = Validator::validateValue($footprintId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length([
                'min' => 0,
                'max' => 100,
            ]),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z0-9_-]{0,100}$/'
            ])
        ]);

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $body = [
            'idFootprint' => $footprintId,
        ];

        return $this->requestFactory->create(
            '/carbon/footprints',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param bool $detailed
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getGetRequest($footprintId, $detailed = false)
    {
        $violations = Validator::validateValue($footprintId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length([
                'min' => 0,
                'max' => 100,
            ]),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z0-9_-]{0,100}$/'
            ])
        ]);
        $violations->addAll(Validator::validateValue($detailed, new Assert\Type('bool')));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }
        
        $query = ['detailed' => 0];
        
        if ($detailed) {
            $query['detailed'] = 1;
        }

        return $this->requestFactory->create(
            "/carbon/footprints/{$footprintId}?".http_build_query($query),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param string $status
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getCloseRequest($footprintId, $status)
    {
        $violations = Validator::validateValue($footprintId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length([
                'min' => 0,
                'max' => 100,
            ]),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z0-9_-]{0,100}$/'
            ])
        ]);
        $violations->addAll(Validator::validateValue($status, [
            new Assert\Type('string'),
            new Assert\Choice(['PURCHASED', 'CLOSED', 'OFFSET_FROM_ANOTHER_VENDOR'])
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }
        
        $body = [
            'status' => $status
        ];

        return $this->requestFactory->create(
            "/carbon/footprints/{$footprintId}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'PATCH'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param WebBrowsingData $webBrowsingData
     *
     * @return RequestInterface
     * @throws Exception
     *
     * @throws ConstraintViolationException
     */
    public function getAddWebBrowsingDataRequest($footprintId, WebBrowsingData $webBrowsingData)
    {
        $violations = Validator::validateValue($footprintId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length([
                'min' => 0,
                'max' => 100,
            ]),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z0-9_-]{0,100}$/'
            ])
        ]);
        $violations->addAll(Validator::validateModel($webBrowsingData));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

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
            "/carbon/footprints/{$footprintId}/web",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $footprintId
     * @param DeliveryData $deliveryData
     *
     * @return RequestInterface
     * @throws Exception
     *
     * @throws ConstraintViolationException
     */
    public function getAddDeliveryDataRequest($footprintId, DeliveryData $deliveryData)
    {
        $violations = Validator::validateValue($footprintId, [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length([
                'min' => 0,
                'max' => 100,
            ]),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z0-9_-]{0,100}$/'
            ])
        ]);
        $violations->addAll(Validator::validateModel($deliveryData));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $body = [
            'totalWeightInKg' => $deliveryData->getTotalWeightInKg(),
            'departure' => [
                'address' => $deliveryData->getDeparture()->getAddress(),
                'zipCode' => $deliveryData->getDeparture()->getZipCode(),
                'city' => $deliveryData->getDeparture()->getCity(),
                'country' => $deliveryData->getDeparture()->getCountry(),
            ],
            'arrival' => [
                'address' => $deliveryData->getArrival()->getAddress(),
                'zipCode' => $deliveryData->getArrival()->getZipCode(),
                'city' => $deliveryData->getArrival()->getCity(),
                'country' => $deliveryData->getArrival()->getCountry(),
            ],
            'transportationExternalId' => $deliveryData->getTransportationExternalId(),
            'deliveryService' => $deliveryData->getDeliveryService()
        ];

        return $this->requestFactory->create(
            "/carbon/footprints/{$footprintId}/delivery",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}