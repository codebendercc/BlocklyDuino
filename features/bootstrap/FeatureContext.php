<?php

namespace codebender\blocklyduino\tests\functional;

use app\Blocklyduino;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\Yaml\Yaml;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends  MinkContext {
    use AMainPageUITrait;

    static private $app;
    public $xpaths;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {
        $this->xpaths = Yaml::parse(file_get_contents(__DIR__ . '/../config/xpaths.yml'));
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

    /** Click on the element with the provided xpath query
     *
     * @param $xpath
     * @return NodeElement|mixed|null
     */
    public function getXPath($xpath)
    {
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

    /** Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $element = $this->getXPath($xpath);

        // ok, let's click on it
        $element->click();
    }

    /**
     * @When I click on the :button button
     */
    public function iClickOnTheButton($button) {
        $this->iClickOnTheElementWithXPath($this->xpaths['Buttons'][$button]);
    }

    /**
     * @Then I should see blocks
     */
    public function iShouldSeeBlocks() {
        $element = $this->getXPath($this->xpaths['Blockly']['iFrame']);
        if (null === $element) {
            throw new \LogicException('Could not find the element using xPath of ' . $this->xpaths['Blockly']['iFrame']);
        }

        \PHPUnit_Framework_Assert::assertTrue($element->isVisible('style'),
            'The Blocks view is not displayed.');
    }

    /**
     * @Then I should see code
     */
    public function iShouldSeeCode() {
        $element = $this->getXPath($this->xpaths['Blockly']['iFrame']);
        if (null === $element) {
            throw new \LogicException('Could not find the element using xPath of ' . $this->xpaths['Blockly']['iFrame']);
        }

        \PHPUnit_Framework_Assert::assertNotTrue($element->isVisible('style'),
                                                 'The Arduino view is not displayed.');
    }
}
