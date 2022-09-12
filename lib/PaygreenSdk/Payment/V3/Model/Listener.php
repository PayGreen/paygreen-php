<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class Listener implements ListenerInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var array<string>
     */
    private $events;

    /**
     * @var string
     */
    private $url;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array<string>
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param array<string> $events
     *
     * @return void
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $type
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
