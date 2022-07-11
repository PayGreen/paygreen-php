<?php

namespace Paygreen\Sdk\Payment\V3\Request\Notification;

use Psr\Http\Message\RequestInterface;

class NotificationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param string $listenerId
     *
     * @return RequestInterface
     */
    public function getGetByListenerRequest($listenerId)
    {
        return $this->requestFactory->create(
            "/notifications/?listener_id=$listenerId",
            null,
            'GET'
        )->withAuthorization()->isJson()->getRequest();
    }

    /**
     * @param string $notificationId
     *
     * @return RequestInterface
     */
    public function getReplayRequest($notificationId)
    {
        return $this->requestFactory->create(
            "/notifications/$notificationId/replay"
        )->withAuthorization()->isJson()->getRequest();
    }
}