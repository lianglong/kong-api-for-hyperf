<?php

namespace lianglong\Kong\Services;

interface TargetInterface
{
    const SERVICE_NAME = 'target';

    public function create($upstream, $body = []);

    public function all($upstream, $body = []);

    public function allActive($upstream);

    public function delete($upstream, $target);
}
