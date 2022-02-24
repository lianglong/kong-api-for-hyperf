<?php

namespace lianglong\Kong\Tests\Units\Services;

use mageekguy\atoum;

/**
 * Class Api
 *
 * @package lianglong\Kong\Tests\Units\Services
 */
class Api extends atoum\test
{

    public function testCreate()
    {
        $factory = new \lianglong\Kong\ServiceFactory();
        /** @var \lianglong\Kong\Services\Api $service */
        $service = $factory->get('api');

        $name = uniqid('apiname', true);

        $response = $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        $this->assert->integer($response->getStatusCode())->isEqualTo(201);

        $api = $response->json();
        $this->assert->array($api)->keys->isEqualTo(
          [
            'created_at',
            'strip_uri',
            'id',
            'name',
            'http_if_terminated',
            'preserve_host',
            'upstream_url',
            'uris',
            'upstream_connect_timeout',
            'upstream_send_timeout',
            'upstream_read_timeout',
            'retries',
            'https_only',
          ]
        );

        $this->assert->string($api['name'])->isEqualTo($name);
    }

    public function testGet()
    {
        $factory = new \lianglong\Kong\ServiceFactory();
        /** @var \lianglong\Kong\Services\Api $service */
        $service = $factory->get('api');

        $name = uniqid('apiname', true);

        $response = $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        $this->assert->integer($response->getStatusCode())->isEqualTo(201);
        $api = $response->json();

        // By name
        $response = $service->retrieve($name);
        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->array($response->json())->isEqualTo($api);

        // By id
        $response = $service->retrieve($api['id']);
        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->array($response->json())->isEqualTo($api);
    }

    public function testAll()
    {
        $factory = new \lianglong\Kong\ServiceFactory();
        /** @var \lianglong\Kong\Services\Api $service */
        $service = $factory->get('api');

        $name = uniqid('apiname', true);
        $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        $name = uniqid('apiname', true);
        $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        // Full list
        $response = $service->all();
        $list = $response->json();

        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->integer($list['total'])->isGreaterThan(1);
        $this->assert->array($list['data'])->size->isGreaterThan(1);

        // Test paging
        $response = $service->all(['size' => 1]);
        $list = $response->json();

        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->integer($list['total'])->isGreaterThan(1);
        $this->assert->array($list['data'])->size->isEqualTo(1);
    }

    public function testUpdateOrCreate()
    {
        $factory = new \lianglong\Kong\ServiceFactory();
        /** @var \lianglong\Kong\Services\Api $service */
        $service = $factory->get('api');

        $name = uniqid('apiname', true);

        $response = $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        $this->assert->integer($response->getStatusCode())->isEqualTo(201);
        $api = $response->json();

        $api['name'] = $name.'-updated';

        // Update
        $response = $service->update($api['id'], $api);
        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->array($response->json())->isEqualTo($api);

        $api['name'] = $name.'-updated-or-created';

        // Update or Create
        $response = $service->updateOrCreate($api);
        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->array($response->json())->isEqualTo($api);

        unset($api['id']);

        // Conflict
        $this->assert->exception(
          function () use ($service, $api) {
              $response = $service->updateOrCreate($api);
          }
        )->message->startWith('Something went wrong when calling kong (409 - Conflict).');
        $this->assert->integer($this->exception->getCode())->isEqualTo(409);
    }

    public function testDelete()
    {
        $factory = new \lianglong\Kong\ServiceFactory();
        /** @var \lianglong\Kong\Services\Api $service */
        $service = $factory->get('api');

        $name = uniqid('apiname', true);

        $response = $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        $this->assert->integer($response->getStatusCode())->isEqualTo(201);
        $api = $response->json();

        // Delete
        $response = $service->delete($api['id']);
        $this->assert->integer($response->getStatusCode())->isEqualTo(204);

        // Conflict
        $this->assert->exception(
          function () use ($service, $api) {
              $response = $service->retrieve($api['id']);
          }
        )->message->startWith('Something went wrong when calling kong (404 - Not Found).');
        $this->assert->integer($this->exception->getCode())->isEqualTo(404);
    }

    public function testPlugin()
    {
        $factory = new \lianglong\Kong\ServiceFactory();
        /** @var \lianglong\Kong\Services\Api $service */
        $service = $factory->get('api');

        $name = uniqid('apiname', true);

        $response = $service->create(
          [
            'name' => $name,
            'uris' => '/ping',
            'upstream_url' => 'http://ping/',
          ]
        );

        $this->assert->integer($response->getStatusCode())->isEqualTo(201);
        $api = $response->json();

        // Plugins
        $response = $service->plugins($api['id']);
        $this->assert->integer($response->getStatusCode())->isEqualTo(200);
        $this->assert->array($response->json())->isEqualTo(['total' => 0, 'data' => []]);

        /** @var \lianglong\Kong\Services\Plugin $plugins */
        $plugins = $factory->get('plugin');

        $response = $plugins->create(
          $api['id'],
          [
            'name' => 'rate-limiting',
            'config' => [
              'minute' => 20,
              'hour' => 500,
            ],
          ]
        );

        $plugin = $response->json();

        $this->assert->array($plugin)->keys->isEqualTo(
          [
            'created_at',
            'config',
            'id',
            'name',
            'api_id',
            'enabled',
          ]
        );
        $this->assert->string($plugin['name'])->isEqualTo('rate-limiting');
    }
}
