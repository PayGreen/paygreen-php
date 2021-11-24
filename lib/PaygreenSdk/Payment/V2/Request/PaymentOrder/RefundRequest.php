<?php

namespace Paygreen\Sdk\Payment\V2\Request\PaymentOrder;

use Psr\Http\Message\RequestInterface;

class RefundRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string   $transactionId
     * @param null|int $amount
     *
     * @return RequestInterface
     */
    public function getCreateRequest($transactionId, $amount = null)
    {
        $publicKey = $this->environment->getPublicKey();

        if (!is_null($amount)) {
            $body = [
                'amount' => $amount,
            ];
        } else {
            $body = null;
        }

        return $this->requestFactory->create(
            "/api/{$publicKey}/payins/transaction/{$transactionId}",
            json_encode($body),
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }
}
