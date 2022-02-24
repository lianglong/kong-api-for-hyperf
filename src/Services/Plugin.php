<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Plugin implements PluginInterface
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($body = [])
    {
        return $this->client->post('/plugins', ['body' => $body]);
    }

    public function retrieve($plugin)
    {
        return $this->client->get('/plugins/'.$plugin);
    }

    public function all($body = [])
    {
        return $this->client->get('/plugins', ['body' => $body]);
    }

    public function update($uuid, $body = [])
    {
        return $this->client->patch('/plugins/'.$uuid, ['body' => $body]);
    }

    public function updateOrCreate($body = [])
    {
        return $this->client->put('/plugins', ['body' => $body]);
    }

    public function delete($uuid)
    {
        return $this->client->delete('/plugins/'.$uuid);
    }

    public function enabled()
    {
        return $this->client->get('/plugins/enabled');
    }

    public function schema($plugin)
    {
        return $this->client->get('/plugins/schema/'.$plugin);
    }
}
