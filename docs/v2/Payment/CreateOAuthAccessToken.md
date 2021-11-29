## How to create OAuth access token :

```php
try {
    $response = $client->createOAuthAccessToken(
        '37.143.52.241', // ip address
        'john.doe@customer.fr', // email
        'johndoe' // name
        'phoneNumber',
        'serverAddress'
    );
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}

```