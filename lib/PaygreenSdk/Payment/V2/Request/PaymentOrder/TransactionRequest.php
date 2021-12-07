<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TransactionRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $transactionId
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getGetRequest($transactionId)
    {
        $violations = Validator::validateValue($transactionId, new Assert\NotBlank());

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/{$transactionId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $transactionId
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getConfirmationRequest($transactionId)
    {
        $violations = Validator::validateValue($transactionId, new Assert\NotBlank());

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $publicKey = $this->environment->getPublicKey();

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/{$transactionId}",
            null,
            'PUT'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $transactionId
     * @param int    $amount
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getUpdateAmountRequest($transactionId, $amount)
    {
        $violations = Validator::validateValue($transactionId, new Assert\NotBlank());
        $violations->addAll(Validator::validateValue($amount, [
            new Assert\NotBlank(),
            new Assert\Type('integer'),
        ]));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $publicKey = $this->environment->getPublicKey();

        $body = [
            'amount' => $amount,
        ];

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/{$transactionId}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'PATCH'
        )->withAuthorization()->isJson()->getRequest();
    }
}
