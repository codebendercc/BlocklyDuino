<?php
// CodebenderServiceProvider.php

namespace codebender\blocklyduino\services;

use GuzzleHttp\Client;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CodebenderServiceProvider implements ServiceProviderInterface
{
    /**
     * @var string The URL for the Codebender website
     */
    protected $codebender_url;

    /**
     * @var string The URL for the builder service
     */
    protected $builder_url;

    /**
     * Default Constructor
     * @param array $config
     */
    function __construct(array $config) {
      $this->codebender_url = $config['codebender_url'];
      $this->builder_url = $config['builder_url'];
    }

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app
     */
    public function register(Application $app) {

        /**
         * Add closures for getting all the Codebender URLs we need to know.
         */
        $app['codebender'] = $app->protect(function ($uri) {
            return sprintf('%s/%s', $this->codebender_url, ltrim($uri, '/'));
        });
        $app['codebender.board'] = $app->protect(function ($uri) use ($app) {
            return sprintf('%s/board/%s', $this->codebender_url, ltrim($uri, '/'));
        });
        $app['codebender.utilities'] = $app->protect(function ($uri) use ($app) {
            return sprintf('%s/utilities/%s', $this->codebender_url, ltrim($uri, '/'));
        });
        $app['codebender.builder'] = $app->protect(function ($uri) use ($app) {
            return sprintf('%s/%s', $this->builder_url, ltrim($uri, '/'));
        });

        /**
         * Add closures for performing requests against Codebender URLs.
         */
        $app['codebender.get'] = $app->protect(function ($url) use ($app) {
            $client = new Client();
            $response = $client->get($url);
            return $response->getBody();
        });

        $app['codebender.post'] = $app->protect(function ($url, $json) use ($app) {
            $client = new Client();
            $response = $client->post($url, ['body' => $json]);
            return $response->getBody();
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app
     */
    public function boot(Application $app) {
    }
}
