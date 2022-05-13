## How to update payment amount :

```php
$response = $paymentClient->createCashPayment($paymentOrder);
$responseData = $response->getData();

$transactionId = $responseData->data->id; // Get the transaction id

$response = $paymentClient->updateTransactionAmount(
    $transactionId,
    5000 // The new amount of the transaction
);
```