<?php

namespace codebender\blocklyduino\tests;

use app\Blocklyduino;
use Silex\WebTestCase;

class FrameTest extends WebTestCase {

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernel
     */
    public function createApplication()
    {
//        require __DIR__ . '/../../app/app.php';
        require_once __DIR__ . '/../../vendor/autoload.php';

        // Create the Blocklyduino Silex application.
        // The constructor handles all the default configuration.
        $app = new Blocklyduino();
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }

    /**
     *
     */
    public function testFrameLoadsDirectly() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/blocklyframe');

        // Assert yoself
        $this->assertTrue($client->getResponse()->isOk());
    }
}