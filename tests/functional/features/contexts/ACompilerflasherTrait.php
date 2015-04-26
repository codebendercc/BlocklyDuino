<?php

namespace codebender\blocklyduino\tests\functional;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\NodeElement;

trait ACompilerflasherTrait {

    /**
     * @Then /^I see "([^"]*)" in the Status box$/
     */
    public function iSeeInTheStatusBox($msg) {
        $this->jqueryWait();
        \PHPUnit_Framework_Assert::assertEquals($msg, $this->getXPath($this->xpaths['Compilerflasher']['Status'])->getText());
    }

    /**
     * @Given /^I do not have the Codebender plugin installed$/
     */
    public function iDoNotHaveTheCodebenderPluginInstalled()
    {
        throw new PendingException('- Figure out how to determine if the Codebender plugin is actually installed.');
    }

    /* Variables and functions that will be overridden by the Context. */
    public $xpaths;
    public $identifiers;
    public function iClickOnTheElementWithXPath($xpath) {}
    public function iSelectAFileToLoad($file) {}
    public function cleanupNewlinesAndWhitespace($file) { return 'Should not see this.'; }
    public function iAcceptTheModalDialog() {}
    public function iReadFixtureFile($file) { return 'Should not see this.'; }
    public function getXPath($xpath) {
        return new NodeElement('You should never see this message. ' .
            'This method is supposed to come from the Context, ' .
            'but we have to mock it here.',
            null);
    }

}
