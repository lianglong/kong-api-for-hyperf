<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Sni implements SniInterface
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($body = [])
    {
        return $this->client->post('/snis/', ['body' => $body]);
    }

    public function retrieve($name)
    {
        return $this->client->post('/snis/'.$name);
    }

    public function all($body = [])
    {
        return $this->client->post('/snis/', ['body' => $body]);
    }

    public function update($name, $body = [])
    {
        return $this->client->post('/snis/'.$name, ['body' => $body]);
    }

    public function updateOrCreate($body = [])
    {
        return $this->client->post('/snis/', ['body' => $body]);
    }

    public function delete($name)
    {
        return $this->client->post('/snis/'.$name);
    }
}
