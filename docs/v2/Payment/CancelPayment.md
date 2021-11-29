## Cancel a payment :

```php
try {
    $response = $paymentClient->createCashPayment($paymentOrder);
    $responseData = $response->getData();
    
    $transactionId = $responseData->data->id; // Get the transaction id
    
    $response = $paymentClient->cancelPayment($transactionId);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```