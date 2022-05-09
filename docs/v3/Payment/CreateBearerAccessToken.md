
## How to create OAuth access token :

```php
$response = $client->authenticate();
$data = json_decode($response->getBody()->getContents())->data;
$client->setBearer($data->token);
```

Then you can use the $client variable to make requests while being authenticated.
