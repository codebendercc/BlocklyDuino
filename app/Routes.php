<?php
// Routes.php

namespace app;

use Symfony\Component\HttpFoundation\Request;

class Routes
{
    /**
     * Configures the routes for the application
     * @param Blocklyduino $app The current application
     */
    static function configure(Blocklyduino $app) {
        self::addRootRoute($app);
        self::addFrameRoute($app);
        self::addBuilderRoutes($app);

        // Now let's define a handy asset path. Note that this has to come
        // after the other route definitions because we use the named URL
        // route.
        $app['asset_path'] = $app->path('home') . 'public/assets';
    }

    /**
     * Adds the paths necessary to punt requests off to CompilerFlasher.
     * @param Blocklyduino $app The current application
     */
    public static function addBuilderRoutes(Blocklyduino $app) {
        /* GET Requests */
        $app->get('/builder/listboards', function () use ($app) {
            return $app['codebender.get']($app['codebender.board']('listboards'));
        })->bind('listboards');

        $app->get('/builder/programmers', function () use ($app) {
            return $app['codebender.get']($app['codebender.board']('programmers'));
        })->bind('programmers');

        $app->get('/builder/utilities/flash/ERROR_CODE', function () use ($app) {
            return $app['codebender.get']($app['codebender.utilities']('flash/ERROR_CODE'));
        })->bind('flash_error_codes');

        /* POST Requests */
        $app->post('/builder/utilities/compile', function (Request $request) use ($app) {
            // Break out what we got
            $builderRequestJSON = $request->getContent();

            // Guzzle it and return the results
            return $app['codebender.post']($app['codebender.builder']('compile'), $builderRequestJSON);
        })->bind('util_compile');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addRootRoute(Blocklyduino $app) {
        $app->get('/', function (Blocklyduino $app) {
            return $app['twig']->render('blockly.html.twig');
        })->bind('home');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addFrameRoute(Blocklyduino $app) {
        $app->get('/blocklyframe', function (Blocklyduino $app) {
            return $app['twig']->render('frame.html.twig');
        })->bind('blocklyframe');
    }
}
