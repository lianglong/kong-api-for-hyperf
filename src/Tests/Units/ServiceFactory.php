<?php

namespace lianglong\Kong\Tests\Units;

use mageekguy\atoum;

/**
 * Class ServiceFactory
 *
 * @package lianglong\Kong\Tests\Units
 */
class ServiceFactory extends atoum\test
{

    public function testFactory()
    {
        $factory = new \lianglong\Kong\ServiceFactory();

        $service = $factory->get('api');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Api');
        $service = $factory->get('certificate');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Certificate');
        $service = $factory->get('consumer');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Consumer');
        $service = $factory->get('plugin');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Plugin');
        $service = $factory->get('sni');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Sni');
        $service = $factory->get('target');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Target');
        $service = $factory->get('upstream');
        $this->assert->object($service)->isInstanceOf('\lianglong\Kong\Services\Upstream');
    }

    public function testFactoryFail()
    {
        $factory = new \lianglong\Kong\ServiceFactory();

        $this->assert->exception(
          function () use ($factory) {
              $factory->get('wrong-service');
          }
        )->hasMessage(
          'The service "wrong-service" is not available. Pick one among "api", "certificate", "consumer", "plugin", "sni", "target", "upstream".'
        );
    }
}
