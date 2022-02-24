<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Services implements ServicesInterface
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($body = [])
    {
        return $this->client->post('/'.self::SERVICE_NAME, ['body' => $body]);
    }

    public function all($body = [])
    {
        return $this->client->get('/'.self::SERVICE_NAME, ['body' => $body]);
    }

    public function retrieve($service)
    {
        return $this->client->get('/'.self::SERVICE_NAME.'/'.$service);
    }

    public function update($service, $body = [])
    {
        return $this->client->patch('/'.self::SERVICE_NAME);
    }

    public function updateOrCreate($service, $body = [])
    {
        return $this->client->put('/'.self::SERVICE_NAME.'/'.$service, $body);
    }

    public function delete($service)
    {
        return $this->client->delete('/'.self::SERVICE_NAME.'/'.$service);
    }
}