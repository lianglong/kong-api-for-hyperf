<?php

namespace lianglong\Kong\Services;

interface UpstreamInterface
{
    const SERVICE_NAME = 'upstream';

    public function create($body = []);

    public function retrieve($name);

    public function all($body = []);

    public function update($name, $body = []);

    public function updateOrCreate($body = []);

    public function delete($name);
}
