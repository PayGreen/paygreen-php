## How to check the validity of a public key:

```php
$publicKey = "pk_xxxxxxxxxxx";
$response = $client->getPublicKey($publicKey);
$data = json_decode($response->getBody()->getContents())->data;

if ($data !== null && $data->revoked_at === null) {
    // public key is valid
} else {
    // public key is NOT valid
}
```
