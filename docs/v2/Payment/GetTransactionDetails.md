## How to get transaction details :

```php
try {
    $response = $paymentClient->createCashPayment($paymentOrder);
    $responseData = $response->getData();
    
    $transactionId = $responseData->data->id; // Get the transaction id
    
    $response = $paymentClient->getTransaction($transactionId);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```