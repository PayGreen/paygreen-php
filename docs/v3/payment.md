---
title: Payment API
excerpt: All functions related to Payment API
category: 62d66960a411210082d84f35
parentDoc: 62d66ab6fa37b4008aa6fa5c
---

# Buyers

## Get a buyer

```php
$client->getBuyer('buy_0000');
```

## List buyers

```php
$client->listBuyer();
```

## Create a buyer

```php
$address = new \Paygreen\Sdk\Payment\V3\Model\Address();
$address->setStreetLineOne('54 Crown Street');
$address->setCity('London');
$address->setCountryCode('UK');
$address->setPostalCode('SW14 6ZG');

$buyer = new \Paygreen\Sdk\Payment\V3\Model\Buyer();
$buyer->setReference('my-customer-id');
$buyer->setEmail('john.doe@customer.fr');
$buyer->setFirstName('John');
$buyer->setLastName('Doe');
$buyer->setBillingAddress($address);

$client->createBuyer($buyer);
```

## Update a buyer

```php
$buyer = new \Paygreen\Sdk\Payment\V3\Model\Buyer();
$buyer->setId('buy_0000');
$buyer->setFirstName('Blank');
$buyer->setLastName('Aux');

$client->updateBuyer($buyer);
```

## Delete a buyer

```php
$client->deleteBuyer('buy_0000');
```

# Payment Orders

## Create a payment order

```php
$address = new \Paygreen\Sdk\Payment\V3\Model\Address();
$address->setStreetLineOne('1 rue de Paris');
$address->setCity('Paris');
$address->setCountryCode('FR');
$address->setPostalCode('75000');

$buyer = new \Paygreen\Sdk\Payment\V3\Model\Buyer();
$buyer->setReference('my-customer-id');
$buyer->setEmail('john.doe@customer.fr');
$buyer->setFirstName('John');
$buyer->setLastName('Doe');
$buyer->setBillingAddress($address);

$paymentOrder = new \Paygreen\Sdk\Payment\V3\Model\PaymentOrder();
$paymentOrder->setReference('my-order-id');
$paymentOrder->setAmount(100);
$paymentOrder->setAutoCapture(true);
$paymentOrder->setCurrency('eur');
$paymentOrder->setShippingAddress($address);
$paymentOrder->setDescription('A test payment');

$response = $client->createPaymentOrder($paymentOrder);
```

## Create a payment order with a buyer id

```php
$address = new \Paygreen\Sdk\Payment\V3\Model\Address();
$address->setStreetLineOne('54 Crown Street');
$address->setCity('London');
$address->setCountryCode('UK');
$address->setPostalCode('SW14 6ZG');

$buyer = new \Paygreen\Sdk\Payment\V3\Model\Buyer();
$buyer->setId('buy_0000');

$paymentOrder = new \Paygreen\Sdk\Payment\V3\Model\PaymentOrder();
$paymentOrder->setReference('my-order-id');
$paymentOrder->setAmount(100);
$paymentOrder->setAutoCapture(true);
$paymentOrder->setCurrency('eur');
$paymentOrder->setShippingAddress($address);
$paymentOrder->setDescription('A test payment');

$response = $client->createPaymentOrder($paymentOrder);
```

## Capture a payment order

To capture a payment order you must have set `auto_capture` to `false` during creation.
Otherwise, the capture will be done automatically, and you don't need to use this route.

```php
// Only if $paymentOrder->setAutoCapture(false);

$response = $client->capturePaymentOrder('po_0000');
```

## Refund a payment order

```php
$response = $client->refundPaymentOrder('po_0000');
```

# Instruments

## Get an instrument

```php
$client->getInstrument('ins_0000');
```

## List instruments

```php
$client->listInstrument();

// You can also list instruments for a specific buyer
$client->listInstrument('buy_0000');
```

## Create an instrument

```php
$instrument = new \Paygreen\Sdk\Payment\V3\Model\Instrument();
$instrument->setToken('card_token');
$instrument->setType('bank_card');
$instrument->setWithAuthorization(true); // Set to false if your instrument does not need authorization
$instrument->setReference('custom_instrument_reference'); // Optional

$client->createInstrument($instrument);
```

## Delete an instrument

```php
$client->deleteInstrument('ins_0000');
```

# Payment Configs

## List payment configs

```php
$client->listPaymentConfig('sh_0000');
```

## Create a payment config

```php
$paymentConfig = new \Paygreen\Sdk\Payment\V3\Model\PaymentConfig();
$paymentConfig->setPlatform('bank_card');
$paymentConfig->setSellingContractId('sel_0000');
$paymentConfig->setCurrency('eur');
$paymentConfig->setConfig(array('config1', 'config2')); // Optional

$client->createPaymentConfig($paymentConfig, 'sh_0000');
```

# Shop

## List shop

```php
$client->listShop();
```

## Create a shop

```php
$client->createShop('my-shop-name', 'my-shop-national-id');
```

## Get a shop

```php
$client->getShop('sh_0000');
```

# Transaction

## List transactions

```php
$client->listTransaction('sh_0000');

// You can also specify a beneficiary shop id
$client->listTransaction('sh_0000', 'sh_0001');
```

## Get transaction

```php
$client->getTransaction('tra_0000');
```