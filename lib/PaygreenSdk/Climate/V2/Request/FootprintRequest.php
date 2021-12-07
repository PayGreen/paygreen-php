<?php

namespace Paygreen\Sdk\Climate\V2\Request;

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
}