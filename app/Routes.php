<?php
// Routes.php

namespace app;

use codebender\blocklyduino\beans\BuilderRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use codebender\blocklyduino\beans;

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
        self::addCompileRoute($app);

        // Now let's define a handy asset path. Note that this has to come
        // after the other route definitions because we use the named URL
        // route.
        $app['asset_path'] = $app->url('home') . 'public/assets';
    }

    /**
     * Adds the CRUD methods for the /compile route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addCompileRoute(Blocklyduino $app)
    {
        if($app['debug'] == true) {
            // Provide a more human-readable post path for testing.
            $app->post('/compile/show', function (Request $request) use ($app) {

                //$builderRequestJSON = $app['debug_code_request']; // Handy debug code

                $code = new BuilderRequest($request->getContent());
                $builderRequestJSON = Utilities::formatJSON($code);

                // Guzzle it and get the results
                $builderResponse = Utilities::postToBuilder($app['builder_url'], $builderRequestJSON);

                // This route (or at least the return value of it)  will probably need to change in order to pass things back to the JavaScript layer
                return $app['twig']->render(
                    'compile.html.twig',
                    array(
                        'request' => $builderRequestJSON,
                        'response' => $builderResponse->getRaw()
                    )
                );
            })->bind('compile_show');
        }

        // This is our default implementation of the /compile path. It returns a JSON.
        $app->post('/compile', function (Request $request) use ($app) {

            //$builderRequestJSON = $app['debug_code_request']; // Handy debug code

            $code = new BuilderRequest($request->getContent());
            $builderRequestJSON = Utilities::formatJSON($code);

            // Guzzle it and get the results
            $builderResponse = Utilities::postToBuilder($app['builder_url'], $builderRequestJSON);

            // This route (or at least the return value of it)  will probably need to change in
            // order to pass things back to the JavaScript layer
            return $builderResponse->getRaw();
        })->bind('compile');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addRootRoute(Blocklyduino $app)
    {
        $app->get('/', function (Blocklyduino $app) { // Match the root route (/) and supply the application as argument
            return $app['twig']->render(
                'blockly.html.twig'
            );
        })->bind('home');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Blocklyduino $app The current application
     */
    public static function addFrameRoute(Blocklyduino $app)
    {
        $app->get('/blocklyframe', function (Blocklyduino $app) {
            return $app['twig']->render(
                'frame.html.twig'
            );
        })->bind('blocklyframe');
    }
}
