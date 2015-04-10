<?php

namespace codebender\blocklyduino\tests\functional;

use Behat\Behat\Tester\Exception\PendingException;

trait AMainPageUITrait {
    /**
     * @Given I am on :arg1
     */
//    public function iAmOn($arg1) {
//        throw new PendingException();
//    }

    /**
     * @When I click on the :arg1 button
     */
    public function iClickOnTheButton($arg1) {
        throw new PendingException();
    }

    /**
     * @Then I should see blocks
     */
    public function iShouldSeeBlocks() {
        throw new PendingException();
    }

    /**
     * @Then I should see code
     */
    public function iShouldSeeCode() {
        throw new PendingException();
    }

}
