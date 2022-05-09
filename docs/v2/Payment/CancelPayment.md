## Cancel a payment :

```php
$response = $paymentClient->createCashPayment($paymentOrder);
$responseData = $response->getData();

$transactionId = $responseData->data->id; // Get the transaction id

$response = $paymentClient->cancelPayment($transactionId);
```