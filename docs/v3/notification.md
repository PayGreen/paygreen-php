---
title: Notification API
excerpt: All functions related to Notification API
category: 62d66960a411210082d84f35
parentDoc: 62d66ab6fa37b4008aa6fa5c
---

# Listeners

## List listeners

```php
$client->listListener('sh_0000');
```

## Create a listener

```php
$listener = new \Paygreen\Sdk\Payment\V3\Model\Listener();
$listener->setType('webhook');
$listener->setEvents(array('payment_order.authorized'));
$listener->setUrl('https://my-store.fr');

$client->createListener($listener, 'sh_0000');
```

## Get a listener

```php
$client->getListener('lis_0000');
```

## Update a listener

```php
/**
* The third argument $params is optional
 * (Authorized values : url, events, type)
 */
$client->updateListener('lis_0000', 'https://my-store.fr', array(
    'events' => array(
        'payment_order.authorized',
        'payment_order.refused'
    )
));
```

## Delete a listener

```php
$client->deleteListener('lis_0000');
```

# Notifications

## List notifications

```php
$client->listNotification('lis_0000');
```

## Replay a notification

```php
$client->replayNotification('not_0000');
```