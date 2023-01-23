---
title: Account API
excerpt: All functions related to Account API
category: 62d66960a411210082d84f35
parentDoc: 62d66ab6fa37b4008aa6fa5c
---

# Shop

## List shop

```php
$client->listShop();
```

## Create a shop

This call is deprecated

~~$client->createShop('my-shop-name', 'my-shop-national-id');~~

You can now pass a shop object as a parameter

```php
$newShop = (new \Paygreen\Sdk\Payment\V3\Model\Shop())
    ->setName('my-shop-name')
    ->setNationalId('my-shop-national-id')
    ->setAddress((new \Paygreen\Sdk\Payment\V3\Model\Address()))
    ->setProperty(value);
    
$client->createShop(null, null, $newShop);
```

## Get a shop

```php
$client->getShop('sh_0000');
```