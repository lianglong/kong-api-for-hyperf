<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Upstream implements UpstreamInterface
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($body = [])
    {
        return $this->client->post('/upstreams/', ['body' => $body]);
    }

    public function retrieve($name)
    {
        return $this->client->get('/upstreams/'.$name);
    }

    public function all($body = [])
    {
        return $this->client->get('/upstreams/', ['body' => $body]);
    }

    public function update($name, $body = [])
    {
        return $this->client->patch('/upstreams/'.$name, ['body' => $body]);
    }

    public function updateOrCreate($body = [])
    {
        return $this->client->put('/upstreams/', ['body' => $body]);
    }

    public function delete($name)
    {
        return $this->client->delete('/upstreams/'.$name);
    }
}
