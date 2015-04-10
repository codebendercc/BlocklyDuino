<?php
/**
 * Created by PhpStorm.
 * User: azyth
 * Date: 4/10/15
 * Time: 7:16 AM
 */
namespace codebender\blocklyduino\tests\loading;

use codebender\blocklyduino\tests\BlocklyduinoTestCase;

class FrameLoadTest extends BlocklyduinoTestCase {

    /**
     * creates a test sketch in the block space?
     *
     * No idea how to do this automatically
     */
    public function testSketch(){

    }

    /**
     * tests that you can load a sketch from a file
     *
     */
    public function testLoad(){

    }
    /**
     * Simply test that the frame that contains the Blockly elements is accessible.
     * @depends testLoad()
     */
    public function testSave() {
        $client = $this->createClient();
        $crawler = $client->request('GET', ...);

        // Assert yoself
        $this->assertTrue($client->getResponse()->isOk());
    }
    /**
     * tests that code verification is successful with a preverified code in the block space.
     * @depends testLoad()
     */
    public function testVerifyCode(){

    }


    /**
     * tests that you can discard all work with discard sketch button
     * @depends testLoad()
     */
    public function testDiscard(){

    }
}