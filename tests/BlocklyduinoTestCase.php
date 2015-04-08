<?php

namespace codebender\blocklyduino\tests;

use app\Blocklyduino;
use Silex\WebTestCase;

class BlocklyduinoTestCase extends WebTestCase {

    /**
     * Creates the application for use in tests.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernel
     */
    public function createApplication()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        // Create the Blocklyduino Silex application.
        // The constructor handles all the default configuration.
        $app = new Blocklyduino();
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }

}