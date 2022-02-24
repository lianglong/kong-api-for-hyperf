<?php

namespace lianglong\Kong;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use lianglong\Kong\Services\Certificate;
use lianglong\Kong\Services\CertificateInterface;
use lianglong\Kong\Services\Consumer;
use lianglong\Kong\Services\ConsumerInterface;
use lianglong\Kong\Services\Plugin;
use lianglong\Kong\Services\PluginInterface;
use lianglong\Kong\Services\Sni;
use lianglong\Kong\Services\SniInterface;
use lianglong\Kong\Services\Target;
use lianglong\Kong\Services\TargetInterface;
use lianglong\Kong\Services\Upstream;
use lianglong\Kong\Services\UpstreamInterface;
use lianglong\Kong\Services\ServicesInterface;
use lianglong\Kong\Services\Services;
use lianglong\Kong\Services\RoutesInterface;
use lianglong\Kong\Services\Routes;

final class ServiceFactory
{
    private static $services = [
      ServicesInterface::SERVICE_NAME => Services::class,
      RoutesInterface::SERVICE_NAME => Routes::class,
      CertificateInterface::SERVICE_NAME => Certificate::class,
      ConsumerInterface::SERVICE_NAME => Consumer::class,
      PluginInterface::SERVICE_NAME => Plugin::class,
      SniInterface::SERVICE_NAME => Sni::class,
      TargetInterface::SERVICE_NAME => Target::class,
      UpstreamInterface::SERVICE_NAME => Upstream::class,
    ];

    private $client;

    public function __construct(array $options = [], LoggerInterface $logger = null, GuzzleClient $guzzleClient = null, ContainerInterface $container = null)
    {
        $this->client = new Client($options, $logger, $guzzleClient, $container);
    }

    public function get($service)
    {
        if (!array_key_exists($service, self::$services)) {
            throw new \InvalidArgumentException(
              sprintf(
                'The service "%s" is not available. Pick one among "%s".',
                $service,
                implode('", "', array_keys(self::$services))
              )
            );
        }

        $class = self::$services[$service];

        return new $class($this->client);
    }
}
