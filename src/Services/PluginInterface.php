<?php

namespace lianglong\Kong\Services;

interface PluginInterface
{
    const SERVICE_NAME = 'plugin';

    public function create($body = []);

    public function retrieve($plugin);

    public function all($body = []);

    public function update($plugin, $body = []);

    public function updateOrCreate($body = []);

    public function delete($plugin);

    public function enabled();

    public function schema($plugin);
}
