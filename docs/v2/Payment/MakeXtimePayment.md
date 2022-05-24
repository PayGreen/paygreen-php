### How to make XTIME payment :

```php
$customer = new Paygreen\Sdk\Payment\V2\Model\Customer(); // Must implement the CustomerInterface
$customer->setId('my-customer-id');
$customer->setEmail('john.doe@customer.fr');
$customer->setFirstName('John');
$customer->setLastName('Doe');

$shippingAddress = new Paygreen\Sdk\Payment\V2\Model\Address(); // Must implement the AddressInterface
$shippingAddress->setStreetLineOne('54 Crown Street');
$shippingAddress->setCity('London');
$shippingAddress->setCountryCode('USA');
$shippingAddress->setPostcode('90017');

$billingAddress = new Paygreen\Sdk\Payment\V2\Model\Address(); // Must implement the AddressInterface
$billingAddress->setStreetLineOne('54 Crown Street');
$billingAddress->setCity('London');
$billingAddress->setCountryCode('UK');
$billingAddress->setPostcode('SW14 6ZG');

$order = new Paygreen\Sdk\Payment\V2\Model\Order() // Must implement the OrderInterface;
$order->setCustomer($customer);
$order->setBillingAddress($billingAddress);
$order->setShippingAddress($shippingAddress);
$order->setReference('my-order-reference');
$order->setAmount(2650);
$order->setCurrency('EUR');

$paymentOrder = new Paygreen\Sdk\Payment\V2\Model\PaymentOrder();
$paymentOrder->setType('XTIME');
$paymentOrder->setOrder($order);
$paymentOrder->setNotifiedUrl('https://localhost/notify');

$multiplePayment = new Paygreen\Sdk\Payment\V2\Model\MultiplePayment();
$multiplePayment->setCycle(40); // Number of cycles
$multiplePayment->setCount(12); // Number of payments
$multiplePayment->setFirstAmount(1500); // Amount of the first payment in cents

$paymentOrder->setMultiplePayment($multiplePayment);

$response = $paymentClient->createXtimePayment($paymentOrder);
```