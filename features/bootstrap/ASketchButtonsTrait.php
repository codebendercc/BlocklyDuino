<?php

namespace codebender\blocklyduino\tests\functional;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\NodeElement;

trait ASketchButtonsTrait {

    /** @var $sketchFile string The file to use for working with the sketch buttons */
    public $sketchFile;

    /** @var $sketchFileContent string The content of the sketch file */
    public $sketchFileContent;

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

    protected function jqueryWait($duration = 1000) {
        $this->getSession()->wait($duration, "(0 === jQuery.active && 0 === jQuery(':animated').length)");
    }

    /**
     * @Given /^I select a sketch to load$/
     */
    public function iSelectASketchToLoad() {
        $this->sketchFile = 'testBlockCode.xml';
        $this->jqueryWait(20000);

        $this->sketchFileContent = $this->iSelectAFileToLoad($this->sketchFile);
    }

    /**
     * @Given /^I select a directory to save the sketch$/
     */
    public function iSelectADirectoryToSaveTheSketch() {
        throw new PendingException();
    }

    /**
     * @Then /^the code on the page should match the sketch file$/
     */
    public function theCodeOnThePageShouldMatchTheSketchFile() {
        $selector = '#' . $this->identifiers['Blockly']['Arduino Code'];
        $arduinoTextarea = $this->getXPath($this->xpaths['Blockly']['Arduino Code']);
        print $arduinoTextarea->getText();
        $this->assertElementContains($selector, $this->sketchFileContent);
    }

    /**
     * @Then /^I should see the saved file in the correct directory$/
     */
    public function iShouldSeeTheSavedFileInTheCorrectDirectory() {
        throw new PendingException();
    }

    /* Variables and functions that will be overridden by the Context. */
    public $xpaths;
    public $identifiers;
    public function iSelectAFileToLoad($file) { return  'File contents not found.'; }
    public function getXPath($xpath) {
        return new NodeElement('You should never see this message. ' .
            'This method is supposed to come from the Context, ' .
            'but we have to mock it here.',
            null);
    }

}
