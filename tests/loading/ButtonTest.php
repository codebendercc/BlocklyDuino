<?php
/**
 * Created by PhpStorm.
 * User: azyth
 * Date: 4/10/15
 * Time: 7:12 AM
 */
namespace codebender\blocklyduino\tests\loading;

use codebender\blocklyduino\tests\BlocklyduinoTestCase;

class ButtonTest extends BlocklyduinoTestCase {

    /**
     * Test the verify button accessable
     *      * and board selection drop down menu

     */
//    public function testVerifyButton() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/...'); //TODO get verify button
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
    /**
     * Tests that verification is successful on an empty block space
     *
     * No code should compile sucessfully,
     * compiling with code is tested in Save Functions
     */
    public function testVerifyNoCode() {
        $client = $this->createClient();
        $crawler1 = $client->request('GET', '/'); //TODO

        $link = $crawler1->selectButton($id ='cb_cf_verify_btn');
        $crawler2 = $client->click($link);

        $this->assertNotEquals($crawler1->filterXPath($id = "cb_cf_operation_output"), $crawler2->filterXPath($id = "cb_cf_operation_output"));
    }
    /**
     * Test the flash button accessable
     *      * and drop down menu

//     */
//    public function testFlashButton() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/...'); //TODO get flash button
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//    /**
//     * Test the flash with programer  button accessable
//     *      * and drop down menu
//     */
//    public function testProgramerButton() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/..'); //TODO get programmer button
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//    /**
//     * Test the port speed button accessable
//     *      * and drop down menu
//
//     */
//    public function testSpeedButton() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/...'); //TODO get speed button
//
//        // Assert yoself
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//    /**
//     * tests that the view tabs are there
//     */
//    public function testTabs() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/view_buttons'); //TODO get blocks tab
//                                                              //TODO get arduino code tab
//        // test both tabs
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//    /**
//     * tests that the load/save/discard buttons are there
//     */
//    public function testSketchButtons() {
//        $client = $this->createClient();
//        $crawler = $client->request('GET', '/discard()'); //TODO get discard
//        $crawler = $client->request('GET', '/fakeload');//TODO get load
//        $crawler = $client->request('GET', '/save()');//TODO get save
//        // test em
//        $this->assertTrue($client->getResponse()->isOk());
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
//    }
//

}