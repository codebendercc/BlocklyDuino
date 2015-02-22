<?php
// Dependencies.php

namespace app;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

class Dependencies {

    /**
     * Registers the application's providers
     * @param Application $app The current application
     */
    static function configure(Application $app){

        // UrlGeneratorService
        $app->register(new UrlGeneratorServiceProvider());

        // Twig
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../src/views', // The path to the templates, which is in our case points to /var/www/views
        ));

    }

}