<?php

namespace lianglong\Kong\Services;

interface ConsumerInterface
{
    const SERVICE_NAME = 'consumer';

    public function create($body = []);

    public function retrieve($consumer);

    public function all($body = []);

    public function update($consumer, $body = []);

    public function updateOrCreate($body = []);

    public function delete($consumer);

    public function allCredentials($consumer, $credential);

    public function createCredential($consumer, $credential, $body = []);

    public function deleteCredential($consumer, $credential, $id);

    public function allPlugins($consumer);

    public function createPlugin($consumer, $body = []);

    public function deletePlugin($consumer, $id);

    public function allAcls($consumer, $body = []);

    public function createAcl($consumer, $body = []);

    public function deleteAcl($consumer, $id);
}
