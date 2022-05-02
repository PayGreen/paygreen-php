
## How to create OAuth access token :

```php
try {
    $response = $client->authenticate();
    $data = json_decode($response->getBody()->getContents())->data;
    $client->setBearer($data->token);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}

```