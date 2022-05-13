
## How to create OAuth access token :

```php
$response = $client->createOAuthAccessToken(
    '123.456.78.910', // ip address
    'john.doe@customer.fr', // email
    'johndoe' // name
    'phoneNumber',
    'serverAddress'
);
```