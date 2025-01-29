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
     * @return self
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * @return self
     */
    public function setEvents($events)
    {
        $this->events = $events;

        return $this;
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
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
