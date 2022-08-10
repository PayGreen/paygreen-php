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
$buyer->setPhoneNumber('0102030405');

$shippingAddress = new Paygreen\Sdk\Payment\V3\Model\Address(); // Or must implement the AddressInterface
$shippingAddress->setStreetLineOne('54 Crown Street');
$shippingAddress->setStreetLineTwo('(optionnal)');
$shippingAddress->setCity('London');
$shippingAddress->setCountryCode('UK');
$shippingAddress->setPostcode('SW14 6ZG');

$billingAddress = new Paygreen\Sdk\Payment\V3\Model\Address(); // Or must implement the AddressInterface
$billingAddress->setStreetLineOne('54 Crown Street');
$billingAddress->setCity('London');
$billingAddress->setCountryCode('UK');
$billingAddress->setPostcode('SW14 6ZG');

$order = new Paygreen\Sdk\Payment\V3\Model\Order(); // Or must implement the OrderInterface;
$order->setBuyer($buyer);
$order->setBillingAddress($billingAddress);
$order->setShippingAddress($shippingAddress);
$order->setReference('my-order-reference');
$order->setAmount(2650);
$order->setCurrency('eur');

$buyer->setBillingAddress($address);


$paymentOrder = new PaymentOrder();
$paymentOrder->setAmount(1000);
$paymentOrder->setBuyer($buyer);
$paymentOrder->setCurrency('eur');
$paymentOrder->setReference('my-order-reference');
$paymentOrder->setShippingAddress($address);

$response = $client->createPaymentOrder($paymentOrder);
```
