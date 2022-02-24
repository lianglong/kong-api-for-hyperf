<?php

namespace lianglong\Kong\Services;

interface SniInterface
{
    const SERVICE_NAME = 'sni';

    public function create($body = []);

    public function retrieve($name);

    public function all($body = []);

    public function update($name, $body = []);

    public function updateOrCreate($body = []);

    public function delete($name);
}
