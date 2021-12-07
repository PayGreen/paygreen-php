## How to make a refund :

```php
try {
    $response = $paymentClient->createCashPayment($paymentOrder);
    $responseData = $response->getData();
    
    $transactionId = $responseData->data->id; // Get the transaction id
    
    $response = $paymentClient->refundPayment($transactionId);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```