<?php

namespace Paygreen\Sdk\Climate\V2\Request;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $footprintId
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getAddProductDataRequest(
        $footprintId,
        $productExternalReference,
        $quantity
    ) {
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
        $violations->addAll(Validator::validateValue($productExternalReference, [
            new Assert\NotBlank(),
            new Assert\Type('string')
        ]));
        $violations->addAll(Validator::validateValue($quantity, [
            new Assert\NotBlank()
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $body = [
            'productExternalReference' => $productExternalReference,
            'quantity' => $quantity
        ];

        return $this->requestFactory->create(
            "/carbon/footprints/{$footprintId}/products",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}