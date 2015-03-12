<?php
// CodebenderServiceProvider.php

namespace codebender\blocklyduino\services;

use GuzzleHttp\Client;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CodebenderServiceProvider implements ServiceProviderInterface
{
    protected $codebender_url = 'https://codebender.cc';

    public function register(Application $app) {
        $app['codebender'] = $app->protect(function ($uri) {
            return sprintf('%s/%s', $this->codebender_url, ltrim($uri, '/'));
        });
        $app['codebender.board'] = $app->protect(function ($uri) use ($app) {
            return sprintf('%s/board/%s', $this->codebender_url, ltrim($uri, '/'));
        });
        $app['codebender.utilities'] = $app->protect(function ($uri) use ($app) {
            return sprintf('%s/utilities/%s', $this->codebender_url, ltrim($uri, '/'));
        });

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

    public function boot(Application $app) {
    }
}
