## How to confirm TOKENIZE payment :

```php
$response = $paymentClient->createTokenizePayment($paymentOrder);
$responseData = $response->getData();

$transactionId = $responseData->data->id; // Get the transaction id

$response = $paymentClient->confirmTransaction($transactionId);
```