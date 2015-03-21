<?php
// CodebenderServiceProvider.php

namespace codebender\blocklyduino\services;

use GuzzleHttp\Client;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

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
     * Default Constructor. Absorbs information from a configuration array.
     * @param array $config Configuration settings.
     */
    function __construct(array $config) {
        if(is_null($config['codebender_url'])) {
            throw new MissingMandatoryParametersException('Missing or incorrectly identified configuration for the Codebender URL.');
        }
        if(is_null($config['builder_url'])) {
            throw new MissingMandatoryParametersException('Missing or incorrectly identified configuration for the Builder URL.');
        }

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
        $app['codebender.builder'] = $app->protect(function () use ($app) {
            return $this->builder_url;
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
