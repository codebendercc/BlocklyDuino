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
    /**
     *tests that the trashcan is there
     */
    public function testTrashcan() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/...'); //TODO

        // Assert yoself
        $this->assertTrue($client->getResponse()->isOk());
    }
    /**
     * tests that the block menu has loaded
     */
    public function testBlockMenu() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/...'); //TODO get blocks menu

        // test both tabs
        $this->assertTrue($client->getResponse()->isOk());
    }
    /**
     * tests that the favicon has loaded properly
     */
    public function testFavIcon() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/favico'); //TODO get favicon
        // test both tabs
        $this->assertTrue($client->getResponse()->isOk());
    }
    /**
     *tests that the header is there
     */
    public function testHeader() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/...'); //TODO

        // Assert yoself
        $this->assertTrue($client->getResponse()->isOk());
    }
    /**
     *tests that the buttonspace is there
     */
    public function testButtonBar() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/...'); //TODO

        // Assert yoself
        $this->assertTrue($client->getResponse()->isOk());
    }

}