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
  - [How to create OAuth access token ?](Payment/CreateOAuthAccessToken.md)
- **Make a payment**
  - [How to make a CASH payment ?](Payment/MakeCashPayment.md)
  - [How to make a RECURRING payment ?](Payment/MakeRecurringPayment.md)
  - [How to make a XTIME payment ?](Payment/MakeXtimePayment.md)
  - [How to make a TOKENIZE payment ?](Payment/MakeTokenizePayment.md)
- **Transaction management**
  - [How to cancel payment ?](Payment/CancelPayment.md)
  - [How to get transaction details ?](Payment/GetTransactionDetails.md)
  - [How to make a refund ?](Payment/RefundTransaction.md)
  - [How to confirm TOKENIZE payment ?](Payment/ConfirmTokenizePayment.md)
  - [How to update payment amount ?](Payment/UpdatePaymentAmount.md)
- **Account management**
  - [How to get available payment type ?](Payment/GetAvailablePaymentType.md)
  - [How to get shop details ?](Payment/GetShopDetails.md)
