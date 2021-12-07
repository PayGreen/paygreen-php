<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Exception;
use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Core\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CancelRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $transactionId
     *
     * @throws Exception
     * @throws ConstraintViolationException
     *
     * @return RequestInterface
     */
    public function getCancelRequest($transactionId)
    {
        $violations = Validator::validateValue($transactionId, new Assert\NotBlank());

        if ($violations->count() > 0) {
            throw new ConstraintViolationException($violations, 'Request parameters validation has failed.');
        }

        $publicKey = $this->environment->getPublicKey();

        $body = [
            'id' => $transactionId,
        ];

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/cancel",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }
}
