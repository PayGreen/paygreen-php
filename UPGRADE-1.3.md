# UPGRADE FROM `1.2.1` TO `1.3.0`

1. We have added a new [ListenerInterface](./lib/PaygreenSdk/Payment/V3/Model/ListenerInterface.php) to simplify the creation of a listener.
   An object implementing this interface is included in our SDK [available here.](./lib/PaygreenSdk/Payment/V3/Model/Listener.php)
   Check your use of `$client->createListener()`:
    ```diff
    - $client->createListener($type, $events, $url, $shopId = null);
    
    + $listener = new Listener();
    + $listener->setType('webhook');
    + $listener->setEvents([\Paygreen\Sdk\Payment\V3\Enum\EventEnum::PAYMENT_ORDER_SUCCESSED]);
    + $listener->setUrl('https://example.com/notify');
    
    + $client->createListener(ListenerInterface $listener, $shopId = null);
    ```

2. We have added a new [PaymentConfigInterface](./lib/PaygreenSdk/Payment/V3/Model/PaymentConfigInterface.php) to simplify the creation of a payment config.
   An object implementing this interface is included in our SDK [available here.](./lib/PaygreenSdk/Payment/V3/Model/PaymentConfig.php)
   Check your use of `$client->createPaymentConfig()`:
    ```diff
    - $client->createPaymentConfig($platform, $currency, $config, $sellingContractId, $shopId = null);
    
    + $paymentConfig = new PaymentConfig();
    + $paymentConfig->setPlatform('bank_card');
    + $paymentConfig->setCurrency('eur');
    + $paymentConfig->setConfig([
    +     'config1' => 1,
    +     'config2' => 2
    + ]);
    + $paymentConfig->setSellingContractId('sel_0000');
    
    + $client->createPaymentConfig(PaymentConfigInterface $paymentConfig, $shopId = null);
    ```
