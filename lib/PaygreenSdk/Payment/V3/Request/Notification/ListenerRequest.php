<?php

namespace Paygreen\Sdk\Payment\V3\Request\Notification;

use Paygreen\Sdk\Core\Encoder\JsonEncoder;
use Paygreen\Sdk\Core\Normalizer\CleanEmptyValueNormalizer;
use Paygreen\Sdk\Core\Serializer\Serializer;
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
     * @param string $type
     * @param array $events
     * @param string $url
     *
     * @return RequestInterface
     */
    public function getCreateRequest($type, $events, $url)
    {
        $body = [
            'shop_id' => $this->environment->getShopId(),
            'type' => $type,
            'events' => $events,
            'url' => $url
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

    /**
     * @param string|null $shopId
     *
     * @return RequestInterface
     */
    public function getListByShopRequest($shopId = null)
    {
        $query = [
            'shop_id' => ($shopId === null) ? $this->environment->getShopId(): $shopId
        ];

        return $this->requestFactory->create(
            "/notifications/listeners?shop_id={$shopId}",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }
}
