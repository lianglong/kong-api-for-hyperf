Kong
====

Kong API Gateway for Hyperf - Microservices Management Layer, delivering high performance and reliability.


Compatibility
=============

Currently supported Kong version: `2.x`.

Supported services:
- Service
- Route
- Certificate
- Consumer
- Plugin
- Sni
- Target
- Upstream

Requires:
- hyperf/guzzle
- hyperf/utils


Install
=======

This library can be installed with composer:

````sh
composer require lianglong/kong-api-for-hyperf
````

Usage
=====

````php
$factory = new \lianglong\Kong\ServiceFactory(['base_uri'=>'http://127.0.0.1:8001']);
/** @var \lianglong\Kong\Services\Services $service */
$service = $factory->get('services');
$response = $service->create(
  [
    'name' => $name,
  ]
);
$ret = $response->json();
var_dump($ret);
````