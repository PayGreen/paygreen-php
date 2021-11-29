### How to make XTIME payment :

```php
$customer = new Paygreen\Sdk\Payment\V2\Model\Customer(); // Must implement the CustomerInterface
$customer->setId('my-customer-id');
$customer->setEmail('john.doe@customer.fr');
$customer->setFirstname('John');
$customer->setLastname('Doe');

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

$orderDetails = new Paygreen\Sdk\Payment\V2\Model\OrderDetails();
$orderDetails->setCycle(40); // Number of cycles
$orderDetails->setCount(12); // Number of payments
$orderDetails->setFirstAmount(1500); // Amount of the first payment in cents

$multiplePayment = new Paygreen\Sdk\Payment\V2\Model\MultiplePayment();
$multiplePayment->setOrderDetails($orderDetails);

$paymentOrder->setMultiplePayment($multiplePayment);

try {
    $response = $paymentClient->createXtimePayment($paymentOrder);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```