<?php

namespace lianglong\Kong\Services;


interface ServicesInterface
{
    const SERVICE_NAME = 'services';

    //Create Service
    public function create($body = []);

    //List All Services
    public function all($body = []);

    //Retrieve Service
    public function retrieve($service);

    //Update Service
    public function update($service, $body = []);

    //Create Or Update Service
    public function updateOrCreate($service, $body = []);

    //Delete Service
    public function delete($service);
}