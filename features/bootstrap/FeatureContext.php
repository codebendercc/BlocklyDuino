<?php

namespace codebender\blocklyduino\tests\functional;

use app\Blocklyduino;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\Yaml\Yaml;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext {

    /* Include any of the traits that define additional steps.*/
    use AMainPageUITrait;
    use ASketchButtonsTrait;

    /* Variables */
    /**
     * @var $app Blocklyduino Silex application
     */
    static private $app;

    /**
     * @var $xpaths array A listing of known xpaths that we'd like to use in our tests
     */
    public $xpaths;
    /**
     * @var $identifiers array A listing of known identifiers that we'd like to use in our tests
     */
    public $identifiers;

    /* Functions */
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
        $this->xpaths = Yaml::parse(file_get_contents(__DIR__ . '/../config/xpaths.yml'));
        $this->identifiers = Yaml::parse(file_get_contents(__DIR__ . '/../config/ids.yml'));
    }

    /**
     * Ensures that the Blocklyduino application and its libraries are loaded before the test suite runs.
     * @static
     * @BeforeSuite
     */
    static public function bootstrapSilex() {
        require_once __DIR__ . '/../../vendor/autoload.php';

        // Create the Blocklyduino Silex application.
        // The constructor handles all the default configuration.
        $app = new Blocklyduino();
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }

    /**
     * Returns one or more Mink Elements associated with the given XPath, if it is on the page.
     * @param $xpath
     * @return NodeElement|mixed|null
     */
    public function getXPath($xpath) {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        ); // runs the actual query and returns the element

        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        return $element;
    }

    /**
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath) {
        $this->getXPath($xpath)->click();
    }

    /**
     * @When I click on the :button button
     */
    public function iClickOnTheButton($button) {
        $this->pressButton($this->identifiers['Buttons'][$button]);
    }

    /**
     * @Given /^I select a file to load$/
     */
    public function iSelectAFileToLoad($file) {
        $this->attachFileToField('load', $file);
    }

    /**
     * @Given /^I read a fixture file named (.*)$/
     */
    public function iReadFixtureFile($file) {
        $path = $file;
        if ($this->getMinkParameter('files_path')) {
            $fullPath = rtrim(realpath($this->getMinkParameter('files_path')), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$path;
            if (is_file($fullPath)) {
                $path = $fullPath;
            }
        }
        return file_get_contents($path);
    }

}
