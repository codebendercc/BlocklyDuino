<?php

namespace codebender\blocklyduino\tests\functional;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\NodeElement;

trait AMainPageUITrait {

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

    /**
     * @Then /^the code on the page should be reset$/
     */
    public function theCodeOnThePageShouldBeReset()
    {
        $defaultCode = $this->cleanupNewlinesAndWhitespace($this->iReadFixtureFile('default_code.ino'));
        $pageCode = $this->cleanupNewlinesAndWhitespace($this->getXPath($this->xpaths['Blockly']['Arduino Code'])->getText());
        $errorMsg = "The Arduino code does not match what was loaded from the file:\n" .
            "Got:\n" . $pageCode . "\n" .
            "Expected:\n" . $defaultCode . "\n";

        \PHPUnit_Framework_Assert::assertTrue(strcmp($pageCode, $defaultCode) == 0, $errorMsg);
    }

    /* Variables and functions that will be overridden by the Context. */
    public $xpaths;
    public function getXPath($xpath) {
        return new NodeElement('You should never see this message. ' .
                               'This method is supposed to come from the Context, ' .
                               'but we have to mock it here.',
                               null);
    }
    public function cleanupNewlinesAndWhitespace($file) { return 'Should not see this.'; }
    public function iReadFixtureFile($file) { return 'Should not see this.'; }

}
