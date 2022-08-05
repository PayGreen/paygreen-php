## How to create a payment order:

```php
$address = new Paygreen\Sdk\Payment\V3\Model\Address(); // Or must implement the AddressInterface
$address->setStreetLineOne('54 Crown Street');
$address->setCity('London');
$address->setCountryCode('UK');
$address->setPostcode('SW14 6ZG');

$buyer = new Paygreen\Sdk\Payment\V3\Model\Buyer(); // Or must implement the CustomerInterface
$buyer->setReference('my-customer-id');
$buyer->setEmail('john.doe@customer.fr');
$buyer->setFirstName('John');
$buyer->setLastName('Doe');
$buyer->setBillingAddress($address);

$paymentOrder = new PaymentOrder();
$paymentOrder->setAmount(1000);
$paymentOrder->setBuyer($buyer);
$paymentOrder->setCurrency('eur');
$paymentOrder->setReference('my-order-reference');
$paymentOrder->setShippingAddress($address);

$response = $client->createPaymentOrder($paymentOrder);
```
