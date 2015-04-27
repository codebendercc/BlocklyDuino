<?php

namespace codebender\blocklyduino\tests\unit\loading;

use codebender\blocklyduino\tests\unit\BlocklyduinoTestCase;

class FrameLoadTest extends BlocklyduinoTestCase {

    /**
     * Simply test that the frame that contains the Blockly elements is accessible.
     */
    public function testFrameLoadsDirectly() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/blocklyframe');

        // Assert
        $this->assertTrue($client->getResponse()->isOk());
    }

}