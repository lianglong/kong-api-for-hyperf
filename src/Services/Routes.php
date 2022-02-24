<?php

namespace lianglong\Kong\Services;


class Routes implements RoutesInterface
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

    public function retrieve($route)
    {
        return $this->client->get('/'.self::SERVICE_NAME.'/'.$route);
    }

    public function update($route, $body = [])
    {
        return $this->client->patch('/'.self::SERVICE_NAME.'/'.$route);
    }

    public function updateOrCreate($route, $body = [])
    {
        return $this->client->put('/'.self::SERVICE_NAME.'/'.$route, $body);
    }

    public function delete($route)
    {
        return $this->client->delete('/'.self::SERVICE_NAME.'/'.$route);
    }
}