<?php

namespace codebender\blocklyduino\tests\functional;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\NodeElement;

trait ASketchButtonsTrait {

    /** @var $sketchFile string The file to use for working with the sketch buttons */
    public $sketchFile;

    /** @var $sketchFileContent string The content of the sketch file */
    public $sketchFileContent;

    /** @var $saveDirectory string The directory to test file saving in */
    public $saveDirectory;

    /**
     * @AfterScenario @cleanup_sketch
     */
    public function discardSketch(AfterScenarioScope $scope)
    {
        $this->iClickOnTheButton('Discard Sketch');
        $this->iAcceptTheModalDialog();
    }

    /**
     * @Given /^I load a sketch$/
     */
    public function iLoadASketch() {
        $this->iAmOnHomepage();
        $this->iClickOnTheButton('Load Sketch');
        $this->iSelectASketchToLoad();
        $this->iClickOnTheButton('Arduino');
        $this->theCodeOnThePageShouldMatchTheSketchFile();
    }

    /**
     * @Given /^I select a sketch to load$/
     */
    public function iSelectASketchToLoad() {
        $this->sketchFile = 'testBlockCode.xml';
        $this->jqueryWait(20000);

        $this->iSelectAFileToLoad($this->sketchFile);
        $this->sketchFileContent = $this->iReadFixtureFile(str_replace('xml', 'ino', $this->sketchFile));
    }

    /**
     * @Given /^I save the sketch$/
     */
    public function iSaveTheSketch() {
        throw new PendingException('- Need to figure out how to manipulate the file save dialog!');
    }

    /**
     * @Then /^the code on the page should match the sketch file$/
     */
    public function theCodeOnThePageShouldMatchTheSketchFile() {
        $pageCode = $this->cleanupNewlinesAndWhitespace($this->getXPath($this->xpaths['Blockly']['Arduino Code'])->getText());
        $fileCode = $this->cleanupNewlinesAndWhitespace($this->sketchFileContent);
        $errorMsg = "The Arduino code does not match what was loaded from the file:\n" .
                    "Got:\n" . $pageCode . "\n" .
                    "Expected:\n" . $fileCode . "\n";

        \PHPUnit_Framework_Assert::assertTrue(strcmp($pageCode, $fileCode) == 0, $errorMsg);
    }

    /**
     * @Then /^I should see the saved file in the correct directory$/
     */
    public function iShouldSeeTheSavedFileInTheCorrectDirectory() {
        throw new PendingException('- Need to figure out how to verify that the file was saved in the specified directory!');
    }

    /* Variables and functions that will be overridden by the Context. */
    public $xpaths;
    public $identifiers;
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
