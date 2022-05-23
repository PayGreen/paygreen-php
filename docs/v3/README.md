# API PayGreen V3 SDK

## Prerequisites

PHP 5.6 and above.

## Usage

First, you need to initialize the HTTP client:
```php
$psr18Client = new Client(); // Must implement the HttpClient interface

$environment = new Paygreen\Sdk\Payment\V3\Environment(
    'YOUR_SHOP_ID',
    'YOUR_SECRET_KEY',
    'SANDBOX' // Possible values : PRODUCTION, SANDBOX
);

$client = new Paygreen\Sdk\Payment\V3\Client($psr18Client, $environment);
```

### Samples

---

- **Authentication**
  - [How to create Bearer access token?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v3/Payment/CreateBearerAccessToken.md)
- **Make a payment**
  - [How to make a payment order?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v3/Payment/MakePaymentOrder.md)
- **Adding payment script on your website**
  - [How to display a payment?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v3/Payment/IntegratePaymentScript.md)

