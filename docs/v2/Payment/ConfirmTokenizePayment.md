## How to confirm TOKENIZE payment :

```php
try {
    $response = $paymentClient->createTokenizePayment($paymentOrder);
    $responseData = $response->getData();
    
    $transactionId = $responseData->data->id; // Get the transaction id
    
    $response = $paymentClient->confirmTransaction($transactionId);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```