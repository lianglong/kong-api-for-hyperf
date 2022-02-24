<?php

namespace lianglong\Kong\Services;

use lianglong\Kong\Client;

class Consumer implements ConsumerInterface
{
    const CREDENTIAL_BASIC = 'basic-auth';
    const CREDENTIAL_APIKEY = 'key-auth';
    const CREDENTIAL_HMAC = 'hmac-auth';
    const CREDENTIAL_LDAP = 'ldap-auth';
    const CREDENTIAL_JWT = 'jwt';
    const CREDENTIAL_OAUTH2 = 'oauth2';

    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    public function create($body = [])
    {
        return $this->client->post('/consumers/', ['body' => $body]);
    }

    public function retrieve($consumer)
    {
        return $this->client->get('/consumers/'.$consumer);
    }

    public function all($body = [])
    {
        return $this->client->get('/consumers/', ['body' => $body]);
    }

    public function update($consumer, $body = [])
    {
        return $this->client->patch('/consumers/'.$consumer, ['body' => $body]);
    }

    public function updateOrCreate($body = [])
    {
        return $this->client->put('/consumers/', ['body' => $body]);
    }

    public function delete($consumer)
    {
        return $this->client->delete('/consumers/'.$consumer);
    }

    public function allCredentials($consumer, $credential, $body = [])
    {
        return $this->client->get('/consumers/'.$consumer.'/'.$credential, ['body' => $body]);
    }

    public function createCredential($consumer, $credential, $body = [])
    {
        return $this->client->post('/consumers/'.$consumer.'/'.$credential, ['body' => $body]);
    }

    public function deleteCredential($consumer, $credential, $id)
    {
        return $this->client->delete('/consumers/'.$consumer.'/'.$credential.'/'.$id);
    }

    public function allPlugins($consumer, $body = [])
    {
        return $this->client->get('/consumers/'.$consumer.'/plugins', ['body' => $body]);
    }

    public function createPlugin($consumer, $body = [])
    {
        return $this->client->post('/consumers/'.$consumer.'/plugins', ['body' => $body]);
    }

    public function deletePlugin($consumer, $id)
    {
        return $this->client->delete('/consumers/'.$consumer.'/plugins/'.$id);
    }

    public function allAcls($consumer, $body = [])
    {
        return $this->client->get('/consumers/'.$consumer.'/acls', ['body' => $body]);
    }

    public function createAcl($consumer, $body = [])
    {
        return $this->client->post('/consumers/'.$consumer.'/acls', ['body' => $body]);
    }

    public function deleteAcl($consumer, $id)
    {
        return $this->client->delete('/consumers/'.$consumer.'/acls/'.$id);
    }
}
