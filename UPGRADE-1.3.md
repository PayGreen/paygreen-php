# UPGRADE FROM `1.2.1` TO `1.3.0`

1. We have added a new [ListenerInterface](./lib/PaygreenSdk/Payment/V3/Model/ListenerInterface.php) to simplify the creation of a listener.
An object implementing this interface is included in our SDK [available here.](./lib/PaygreenSdk/Payment/V3/Model/Listener.php)
   Check your use of `$client->createListener()`:
    ```diff
    - $client->createListener($type, $events, $url);
    + $client->$client->createListener(ListenerInterface $listener, $shopId = null);
    ```