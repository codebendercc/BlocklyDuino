<?php

namespace codebender\blocklyduino\tests\functional;

use app\Blocklyduino;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends  MinkContext {
    use AMainPageUITrait;

    static private $app;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
    }

    /**
     * @static
     * @BeforeSuite
     */
    static public function bootstrapSilex()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        // Create the Blocklyduino Silex application.
        // The constructor handles all the default configuration.
        $app = new Blocklyduino();
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
}
