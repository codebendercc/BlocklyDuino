<?php
// Dependencies.php

namespace app;

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

class Dependencies {

    /**
     * Registers the application's providers
     * @param Blocklyduino $app The current application
     */
    static function configure(Blocklyduino $app){

        // UrlGeneratorService
        $app->register(new UrlGeneratorServiceProvider());

        // Twig
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../src/views', // The path to the templates, which is in our case points to /var/www/views
        ));

        $app['twig'] = $app->share($app->extend('twig', function(\Twig_Environment $twig) use ($app) {

            $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
                // implement whatever logic you need to determine the asset path

                return sprintf('%s/%s', $app['asset_path'] ,ltrim($asset, '/'));
            }));

            $twig->addFunction(new \Twig_SimpleFunction('css', function ($css) use ($app) {
                // implement whatever logic you need to determine the css path

                return sprintf('%s/css/%s', $app['asset_path'], ltrim($css, '/'));
            }));

            $twig->addFunction(new \Twig_SimpleFunction('script', function ($script) use ($app) {
                // implement whatever logic you need to determine the script path

                return sprintf('%s/script/%s', $app['asset_path'], ltrim($script, '/'));
            }));

            $twig->addFunction(new \Twig_SimpleFunction('image', function ($image) use ($app) {
                // implement whatever logic you need to determine the image path

                return sprintf('%s/images/%s', $app['asset_path'], ltrim($image, '/'));
            }));

            $twig->addFunction(new \Twig_SimpleFunction('blocklyduino_lib', function ($blockly) use ($app) {
                // implement whatever logic you need to determine the blocklyduino path

                return sprintf('%sblockly/apps/blocklyduino/%s', $app->url('home'), ltrim($blockly, '/'));
            }));

            $twig->addFunction(new \Twig_SimpleFunction('blockly_apps_lib', function ($blockly) use ($app) {
                // implement whatever logic you need to determine the blockly apps path

                return sprintf('%sblockly/apps/%s', $app->url('home'), ltrim($blockly, '/'));
            }));

            $twig->addFunction(new \Twig_SimpleFunction('blockly_lib', function ($blockly) use ($app) {
                // implement whatever logic you need to determine the blockly path

                return sprintf('%sblockly/%s', $app->url('home'), ltrim($blockly, '/'));
            }));

            return $twig;
        }));


    }

}