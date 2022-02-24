<?php

namespace lianglong\Kong;

use Hyperf\Guzzle\HandlerStackFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;
use Hyperf\Utils\ApplicationContext;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\Container\ContainerInterface;
use lianglong\Kong\Exception\ClientException;
use lianglong\Kong\Exception\ServerException;

final class Client implements ClientInterface
{
    /** @var ClientInterface */
    private $client;
    /** @var LoggerInterface */
    private $logger;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(array $options = array(), LoggerInterface $logger = null, GuzzleClientInterface $client = null, ContainerInterface $container = null)
    {
        $baseUri = 'http://127.0.0.1:8001';

        if (isset($options['base_uri'])) {
            $baseUri = $options['base_uri'];
        } elseif (getenv('KONG_HTTP_ADDR') !== false) {
            $baseUri = getenv('KONG_HTTP_ADDR');
        }

        $options = array_replace(array(
            'base_uri' => $baseUri,
            'http_errors' => false,
        ), $options);

        $connectPoolOptions = [
//            'min_connections' => 1,
//            'max_connections' => 30,
//            'wait_timeout' => 3.0,
//            'max_idle_time' => 60,
        ];

        $this->container = $container ?: ApplicationContext::getContainer();
        $hasMake = method_exists($this->container, 'make');
        $config = array_replace(['handler' => (new HandlerStackFactory())->create($connectPoolOptions)], $options);

        $this->client = $client ?: ($hasMake ? $this->container->make(GuzzleClient::class, ['config' => $config]) : new GuzzleClient($config));
        $this->logger = $logger ?: new NullLogger();
    }

    public function get($url = null, array $options = array())
    {
        return $this->doRequest('GET', $url, $options);
    }

    public function head($url, array $options = array())
    {
        return $this->doRequest('HEAD', $url, $options);
    }

    public function delete($url, array $options = array())
    {
        return $this->doRequest('DELETE', $url, $options);
    }

    public function put($url, array $options = array())
    {
        return $this->doRequest('PUT', $url, $options);
    }

    public function patch($url, array $options = array())
    {
        return $this->doRequest('PATCH', $url, $options);
    }

    public function post($url, array $options = array())
    {
        return $this->doRequest('POST', $url, $options);
    }

    public function options($url, array $options = array())
    {
        return $this->doRequest('OPTIONS', $url, $options);
    }

    private function doRequest($method, $url, $options)
    {
        if (isset($options['body']) && is_array($options['body'])) {
            $options['body'] = json_encode($options['body']);
        }

        $options['headers']['Content-Type'] = 'application/json';

        $this->logger->info(sprintf('%s "%s"', $method, $url));
        $this->logger->debug(sprintf('Requesting %s %s', $method, $url), array('options' => $options));

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (TransferException $e) {
            $message = sprintf('Something went wrong when calling kong (%s).', $e->getMessage());

            $this->logger->error($message);

            throw new ServerException($message);
        }

        $this->logger->debug(sprintf("Response:\n%s", $this->formatResponse($response)));

        if (400 <= $response->getStatusCode()) {
            $message = sprintf('Something went wrong when calling kong (%s - %s).', $response->getStatusCode(), $response->getReasonPhrase());

            $this->logger->error($message);

            $message .= "\n".(string) $response->getBody();
            if (500 <= $response->getStatusCode()) {
                throw new ServerException($message, $response->getStatusCode());
            }

            throw new ClientException($message, $response->getStatusCode());
        }

        return new KongResponse($response->getHeaders(), (string) $response->getBody(), $response->getStatusCode());
    }

    private function formatResponse(Response $response)
    {
        $headers = array();

        foreach ($response->getHeaders() as $key => $values) {
            foreach ($values as $value) {
                $headers[] = sprintf('%s: %s', $key, $value);
            }
        }

        return sprintf("%s\n\n%s", implode("\n", $headers), $response->getBody());
    }
}
