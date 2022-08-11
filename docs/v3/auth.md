---
title: Auth API
excerpt: All functions related to Auth API
category: 62d66960a411210082d84f35
parentDoc: 62d66ab6fa37b4008aa6fa5c
---

## Create a bearer access token

Retrieve a bearer token from your shop using your secret key

```php
$response = $client->authenticate();
$data = json_decode($response->getBody()->getContents())->data;
$client->setBearer($data->token);
```

Then you can use the `$client` variable to make requests while being authenticated.

## Get a public key

```php
$publicKey = "pk_0000";
$response = $client->getPublicKey($publicKey);
$data = json_decode($response->getBody()->getContents())->data;

if ($data !== null && $data->revoked_at === null) {
    // public key is valid
} else {
    // public key is NOT valid
}
```
