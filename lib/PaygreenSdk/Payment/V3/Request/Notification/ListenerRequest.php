<?php

namespace Paygreen\Sdk\Payment\V3\Request\Notification;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
use Paygreen\Sdk\Payment\V3\Model\ListenerInterface;
use Psr\Http\Message\RequestInterface;

class ListenerRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $listenerId
     *
     * @return RequestInterface
     */
    public function getGetRequest($listenerId)
    {
        return $this->requestFactory->create(
            "/notifications/listeners/{$listenerId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param ListenerInterface $listener
     * @param string|null $shopId
     *
     * @return RequestInterface
     */
    public function getCreateRequest(ListenerInterface $listener, $shopId = null)
    {
        if ($shopId === null) {
            $shopId = $this->environment->getShopId();
        }

        $body = [
            'shop_id' => $shopId,
            'type' => $listener->getType(),
            'events' => $listener->getEvents(),
            'url' => $listener->getUrl()
        ];

        return $this->requestFactory->create(
            "/notifications/listeners",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $listenerId
     * @param string $url
     *
     * @return RequestInterface
     */
    public function getUpdateRequest($listenerId, $url)
    {
        $body = ['url' => $url];

        return $this->requestFactory->create(
            "/notifications/listeners/{$listenerId}",
            (new Serializer([new CleanEmptyValueNormalizer()], [new JsonEncoder()]))->serialize($body, 'json')
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $listenerId
     *
     * @return RequestInterface
     */
    public function getDeleteRequest($listenerId)
    {
        return $this->requestFactory->create(
            "/notifications/listeners/{$listenerId}",
            null,
            'DELETE'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**+
     * @param $filters
     * @param $pagination
     * @return RequestInterface
     */
    public function getListRequest($filters = [], $pagination = [])
    {
        return $this->requestFactory->create(
            "/notifications/listeners?" . $this->getListParameters($filters, $pagination),
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}
