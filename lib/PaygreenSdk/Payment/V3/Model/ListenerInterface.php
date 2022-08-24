<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface ListenerInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType($type);

    /**
     * @return array<string>
     */
    public function getEvents();

    /**
     * @param array<string> $events
     *
     * @return void
     */
    public function setEvents($events);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl($url);
}
