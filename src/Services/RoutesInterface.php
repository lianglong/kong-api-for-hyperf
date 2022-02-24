<?php

namespace lianglong\Kong\Services;


interface RoutesInterface
{
    const SERVICE_NAME = 'routes';

    //Create Route
    public function create($body = []);

    //List All Routes
    public function all($body = []);

    //Retrieve Route
    public function retrieve($route);

    //Update Route
    public function update($route, $body = []);

    //Create Or Update Route
    public function updateOrCreate($route, $body = []);

    //Delete Route
    public function delete($route);
}