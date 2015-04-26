<?php

namespace codebender\blocklyduino\tests\loading;

use codebender\blocklyduino\tests\BlocklyduinoTestCase;

class FrameLoadTest extends BlocklyduinoTestCase {

    /**
     * Simply test that the frame that contains the Blockly elements is accessible.
     */
    public function testFrameLoadsDirectly() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/blocklyframe');

        // Assert yoself
        $this->assertTrue($client->getResponse()->isOk());
    }

}