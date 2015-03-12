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
    static function configure(Blocklyduino $app)
    {
        self::addRootRoute($app);
        self::addFrameRoute($app);
        self::addBuilderRoute($app);

        // Now let's define a handy asset path. Note that this has to come
        // after the other route definitions because we use the named URL
        // route.
        $app['asset_path'] = $app->url('home') . 'public/assets';
    }

    /**
     * Adds the CRUD methods for the /builder route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addBuilderRoute(Blocklyduino $app)
    {
        if($app['debug'] == true) {
            // Provide a more human-readable post path for testing.
            $app->post('/builder/show', function (Request $request) use ($app) {

                //$builderRequestJSON = $app['debug_code_request']; // Handy debug code
                $builderRequestJSON = $request->getContent();

                // Guzzle it and get the results
                $builderResponse = $app['codebender.post']($app['builder_url'], $builderRequestJSON);

                // This route (or at least the return value of it)  will probably need to change in order to pass things back to the JavaScript layer
                return $app['twig']->render(
                    'compile.html.twig',
                    array(
                        'request' => $builderRequestJSON,
                        'response' => $builderResponse
                    )
                );
            })->bind('builder_show');
        }

        // This is our default implementation of the /builder path. It returns a JSON.
        $app->post('/builder', function (Request $request) use ($app) {

            //$builderRequestJSON = $app['debug_code_request']; // Handy debug code
            $builderRequestJSON = $request->getContent();

            // Guzzle it and get the results
            $builderResponse = $app['codebender.post']($app['builder_url'], $builderRequestJSON);

            // This route (or at least the return value of it)  will probably need to change in
            // order to pass things back to the JavaScript layer
            return $builderResponse;
        })->bind('builder');


        /**
         * The following paths are necessary to support our reimplementation of CompilerFlasher.
         */
        $app->get('/builder/listboards', function () use ($app) {
            return $app['codebender.get']($app['codebender.board']('listboards'));
        })->bind('listboards');

        $app->get('/builder/programmers', function () use ($app) {
            return $app['codebender.get']($app['codebender.board']('programmers'));
        })->bind('programmers');

        $app->get('/builder/utilities/flash/ERROR_CODE', function () use ($app) {
            return $app['codebender.get']($app['codebender.utilities']('flash/ERROR_CODE'));
        })->bind('flash_error_codes');

        $app->post('/builder/utilities/compile', function (Request $request) use ($app) {
            // Break out what we got
            $builderRequestJSON = $request->getContent();

            // Guzzle it and return the results
            return $app['codebender.post']($app['codebender.utilities']('compile'), $builderRequestJSON);
        })->bind('util_compile');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addRootRoute(Blocklyduino $app)
    {
        $app->get('/', function (Blocklyduino $app) { // Match the root route (/) and supply the application as argument
            return $app['twig']->render('blockly.html.twig');
        })->bind('home');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addFrameRoute(Blocklyduino $app)
    {
        $app->get('/blocklyframe', function (Blocklyduino $app) {
            return $app['twig']->render('frame.html.twig');
        })->bind('blocklyframe');
    }
}
