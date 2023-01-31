---
title: Account API
excerpt: All functions related to Account API
category: 62d66960a411210082d84f35
parentDoc: 62d66ab6fa37b4008aa6fa5c
---

# Shop

## Get a shop

```php
$client->getShop('sh_0000');
```

## List shop

```php

// available filters
$filters = [
    'name' => 'My shop name', // string
    'commercial_name' => 'My commercial shop name', // string
    'national_id' => '25432169874563', // string
    'marketplace' => false // boolean
];

// pagination settings
$pagination = [
    'max_per_page' => 5,
    'page' => 2
];

// call
$response = $client->listShop($filters, $pagination);

// response
$jsonResponse = json_decode($response->getBody()->getContents());
$data = $jsonResponse->data;
$pagination = $jsonResponse->pagination;

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