<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Certificate implements CertificateInterface
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($body = [])
    {
        return $this->client->post('/certificates/', ['body' => $body]);
    }

    public function retrieve($name)
    {
        return $this->client->get('/certificates/'.$name);
    }

    public function all($body = [])
    {
        return $this->client->get('/certificates/', ['body' => $body]);
    }

    public function update($name, $body = [])
    {
        return $this->client->patch('/certificates/'.$name, ['body' => $body]);
    }

    public function updateOrCreate($body = [])
    {
        return $this->client->put('/certificates/', ['body' => $body]);
    }

    public function delete($name)
    {
        return $this->client->delete('/certificates/'.$name);
    }
}
