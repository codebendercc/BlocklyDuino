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

    public function testBoardList(){
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');


        $this->assertEquals("Ardunio Uno",$crawler->filterXPath("//select[@id='cb_cf_boards']")->eq(0)->text());
       // $this->assertEquals(1, $crawler->filter('body:contains("Ardunio Uno")')->count());
    }
//    /**
//     *tests that the trashcan is there
//     */
//    public function testTrashcan() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/...'); //TODO
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//    /**
//     * tests that the block menu has loaded
//     */
//    public function testBlockMenu() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/cb_cf_boards'); //TODO get blocks menu
//
//        // test both tabs
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->assertContains("Ardunio Uno",$crawler);
//    }
//    /**
//     * tests that the favicon has loaded properly
//     */
//    public function testFavIcon() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/favicon.ico');
//
//        $this->assertTrue($client->getResponse()->isOk());
//    }
//    /**
//     *tests that the header is there
//     */
//    public function testHeader() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/<h4>'); //TODO ??
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//    /**
//     *tests that the buttonspace is there
//     */
//    public function testButtonBar() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/sketch_buttons'); //TODO
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }

}