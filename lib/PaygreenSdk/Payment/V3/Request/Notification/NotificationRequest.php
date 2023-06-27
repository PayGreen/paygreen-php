<?php

namespace Paygreen\Sdk\Payment\V3\Request\Notification;

use Psr\Http\Message\RequestInterface;

class NotificationRequest extends \Paygreen\Sdk\Core\Request\Request
{
    /**
     * @param $filters
     * @param $pagination
     * @return RequestInterface
     */
    public function getGetByListenerRequest($filters = [], $pagination = [])
    {
        return $this->requestFactory->create(
            '/notifications/?' . $this->getListParameters($filters, $pagination),
            null,
            'GET'
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
            '/notifications/listeners?' . $this->getListParameters($filters, $pagination),
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
            '/notifications/' . urlencode($notificationId) . '/replay'
        )->withAuthorization()->isJson()->getRequest();
    }
}