<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RefundRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string   $transactionId
     * @param null|int $amount
     *
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getCreateRequest($transactionId, $amount = null)
    {
        $violations = Validator::validateValue($transactionId, new Assert\NotBlank());
        $violations->addAll(Validator::validateValue($amount, new Assert\Type('integer')));

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $publicKey = $this->environment->getPublicKey();

        if (!is_null($amount)) {
            $body = [
                'amount' => $amount,
            ];
        } else {
            $body = array();
        }

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/{$transactionId}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json'),
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }
}
