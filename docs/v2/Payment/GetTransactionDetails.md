## How to get transaction details :

```php
$response = $paymentClient->createCashPayment($paymentOrder);
$responseData = $response->getData();

$transactionId = $responseData->data->id; // Get the transaction id

$response = $paymentClient->getTransaction($transactionId);
```