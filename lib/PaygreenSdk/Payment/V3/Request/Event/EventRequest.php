<?php

namespace Paygreen\Sdk\Payment\V3\Request\Event;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Psr\Http\Message\RequestInterface;

class EventRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $type
     * @param string|array $content
     *
     * @return RequestInterface
     */
    public function getCreateRequest(
        $type,
        $content
    ) {
        $body = [
            'type' => $type,
            'content' => $content
        ];

        return $this->requestFactory->create(
            '/events',
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

}
