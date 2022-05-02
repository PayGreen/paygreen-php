## How to create a payment order:

```php
$buyer = new Paygreen\Sdk\Payment\V3\Model\Buyer(); // Must implement the CustomerInterface
$buyer->setId('my-customer-id');
$buyer->setEmail('john.doe@customer.fr');
$buyer->setFirstname('John');
$buyer->setLastname('Doe');
$buyer->setCountryCode('FR');

$shippingAddress = new Paygreen\Sdk\Payment\V3\Model\Address(); // Must implement the AddressInterface
$shippingAddress->setStreetLineOne('54 Crown Street');
$shippingAddress->setStreetLineTwo('(optionnal)');
$shippingAddress->setCity('London');
$shippingAddress->setCountryCode('UK');
$shippingAddress->setPostcode('SW14 6ZG');

$billingAddress = new Paygreen\Sdk\Payment\V3\Model\Address(); // Must implement the AddressInterface
$billingAddress->setStreetLineOne('54 Crown Street');
$billingAddress->setCity('London');
$billingAddress->setCountryCode('UK');
$billingAddress->setPostcode('SW14 6ZG');

$order = new Paygreen\Sdk\Payment\V3\Model\Order(); // Must implement the OrderInterface;
$order->setBuyer($buyer);
$order->setBillingAddress($billingAddress);
$order->setShippingAddress($shippingAddress);
$order->setReference('my-order-reference');
$order->setAmount(2650);
$order->setCurrency('eur');

$paymentOrder = new PaymentOrder();
$paymentOrder->setOrder($order);
$paymentOrder->setAutoCapture(true); // true or false, true by default

try {
    $response = $client->createOrder($paymentOrder);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```