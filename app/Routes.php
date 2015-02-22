<?php
// Routes.php

namespace app;

use codebender\blocklyduino\beans\BuilderRequest;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use codebender\blocklyduino\beans;

class Routes
{
    /**
     * Configures the routes for the application
     * @param Application $app The current application
     */
    static function configure(Application $app)
    {
        self::addRootRoute($app);
        self::addCompileRoute($app);
    }

    /**
     * Adds the CRUD methods for the /compile route of the application
     * @param Application $app The current application
     */
    public static function addCompileRoute(Application $app)
    {
        if($app['debug'] == true) {
            // Provide a more human-readable post path for testing.
            $app->post('/compile/show', function (Request $request) use ($app) { // The code will be sent in via the request body

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
        $app->post('/compile', function (Request $request) use ($app) { // The code will be sent in via the request body

            //$builderRequestJSON = $app['debug_code_request']; // Handy debug code

            $code = new BuilderRequest($request->getContent());
            $builderRequestJSON = Utilities::formatJSON($code);

            // Guzzle it and get the results
            $builderResponse = Utilities::postToBuilder($app['builder_url'], $builderRequestJSON);

            // This route (or at least the return value of it)  will probably need to change in order to pass things back to the JavaScript layer
            return $builderResponse->getRaw();
        })->bind('compile');
    }

    /**
     * Adds the CRUD methods for the / route of the application
     * @param Application $app The current application
     */
    public static function addRootRoute(Application $app)
    {
        $app->get('/', function (Application $app) { // Match the root route (/) and supply the application as argument
            return $app['twig']->render(
                'blockly.html.twig',
                array('code' => "") // Just passing this in as a sort of placeholder for now. May not actually need it.
            );
        })->bind('blockly');
    }
}
