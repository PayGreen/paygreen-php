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

3. We corrected the confusion between `id` and `reference` variables.
   `id` is always the PayGreen API side identifier
   `reference` is always your identifier and is not used by PayGreen

4. We have removed the `Order` model. This implies a modification of the `PaymentOrder` model. 
   Example of the changes induced for the creation of a payment order:
   ```diff
   $buyer = new Paygreen\Sdk\Payment\V3\Model\Buyer();
   $buyer->setId('buy_0000');
   
   - $order = new Paygreen\Sdk\Payment\V3\Model\Order();
   - $order->setBuyer($buyer);
   - $order->setReference('my-order-reference');
   - $order->setAmount(2650);
   - $order->setCurrency('eur');
   
   $paymentOrder = new PaymentOrder();
   - $paymentOrder->setOrder($order);
   + $paymentOrder->setAmount(2650);
   + $paymentOrder->setBuyer($buyer);
   + $paymentOrder->setCurrency('eur');
   + $paymentOrder->setReference('my-order-reference');
   
   $response = $client->createPaymentOrder($paymentOrder);
    ```