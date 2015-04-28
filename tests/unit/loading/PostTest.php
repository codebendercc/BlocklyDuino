<?php

namespace codebender\blocklyduino\tests\unit\loading;

use codebender\blocklyduino\tests\unit\BlocklyduinoTestCase;

class PostTest extends BlocklyduinoTestCase {

    public function testPublishTwigPaths() {
        $client = $this->createClient();

        $this->markTestIncomplete('Silex publish correctly.');
        $this->markTestIncomplete("Dependencies::addBlocklyduinioAssets");
    }

}