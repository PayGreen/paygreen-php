# API PayGreen V2 SDK

## Prerequisites

PHP 5.6 and above.

## Usage

First, you need to initialize the HTTP client:
```php
$client = new Client(); // Must implement the HttpClient interface

$environment = new Environment(
    'YOUR_PUBLIC_KEY',
    'YOUR_PRIVATE_KEY',
    'SANDBOX', // Possible values : PRODUCTION, SANDBOX
    2,
    'my-application-name',
    'my-application-version'
);

$paymentClient = new PaymentClient(new Client(), $environment);
```

### Samples

---

- **Authentication**
  - [How to create OAuth access token ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/CreateOAuthAccessToken.md)
- **Make a payment**
  - [How to make a CASH payment ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/MakeCashPayment.md)
  - [How to make a RECURRING payment ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/MakeRecurringPayment.md)
  - [How to make a XTIME payment ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/MakeXtimePayment.md)
  - [How to make a TOKENIZE payment ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/MakeTokenizePayment.md)
- **Transaction management**
  - [How to cancel payment ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/CancelPayment.md)
  - [How to get transaction details ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/GetTransactionDetails.md)
  - [How to make a refund ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/RefundTransaction.md)
  - [How to confirm TOKENIZE payment ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/ConfirmTokenizePayment.md)
  - [How to update payment amount ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/UpdatePaymentAmount.md)
- **Account management**
  - [How to get available payment type ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/GetAvailablePaymentType.md)
  - [How to get shop details ?](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/Payment/GetShopDetails.md)
