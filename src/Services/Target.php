<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Target implements TargetInterface
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($upstream, $body = [])
    {
        return $this->client->post('/upstreams/'.$upstream.'/targets', ['body' => $body]);
    }

    public function all($upstream, $body = [])
    {
        return $this->client->get('/upstreams/'.$upstream.'/targets', ['body' => $body]);
    }

    public function allActive($upstream)
    {
        return $this->client->get('/upstreams/'.$upstream.'/targets/active');
    }

    public function delete($upstream, $target)
    {
        return $this->client->delete('/upstreams/'.$upstream.'/targets/'.$target);
    }
}
