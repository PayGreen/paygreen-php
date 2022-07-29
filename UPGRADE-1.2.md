# UPGRADE FROM `1.1.1` TO `1.2.0`

1. We have renamed some functions whose names were incorrect.
   Check your use of `Paygreen\Sdk\Payment\V3\Client`:
    ```diff
    - $client->getListenerByShop();
    + $client->listListenerByShop();
    
    - $client->createOrder();
    + $client->createPaymentOrder();
    
    - $client->getOrder();
    + $client->getPaymentOrder();
    
    - $client->captureOrder();
    + $client->capturePaymentOrder();

    - $client->refundOrder();
    + $client->refundPaymentOrder();
    ```  

2. We have renamed `Paygreen\Sdk\Payment\V3\Enum\ModeEnum` to `Paygreen\Sdk\Payment\V3\Enum\PaymentModeEnum`
    ```diff
    - Paygreen\Sdk\Payment\V3\Enum\ModeEnum::INSTANT;
    + Paygreen\Sdk\Payment\V3\Enum\PaymentModeEnum::INSTANT;
    ```
