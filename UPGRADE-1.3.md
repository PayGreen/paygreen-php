# UPGRADE FROM `1.2.1` TO `1.3.0`

1. We have added a new [ListenerInterface](./lib/PaygreenSdk/Payment/V3/Model/ListenerInterface.php) to simplify the creation of a listener.
   An object implementing this interface is included in our SDK [available here.](./lib/PaygreenSdk/Payment/V3/Model/Listener.php)
   Check your use of `$client->createListener()`:
    ```diff
    - $client->createListener($type, $events, $url);
    
    + $this->listener = new Listener();
    + $this->listener->setType('webhook');
    + $this->listener->setEvents([\Paygreen\Sdk\Payment\V3\Enum\EventEnum::PAYMENT_ORDER_SUCCESSED]);
    + $this->listener->setUrl('https://example.com/notify');
    
    + $client->createListener(ListenerInterface $listener);
    ```
