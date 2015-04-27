<?php
/**
 * Created by PhpStorm.
 * User: azyth
 * Date: 4/27/15
 * Time: 11:33 AM
 */

namespace codebender\blocklyduino\tests\unit\loading;

use codebender\blocklyduino\tests\unit\BlocklyduinoTestCase;

class PostTest extends BlocklyduinoTestCase {

    /**
     *
     */
    public function testPublishTwigPaths() {
        $client = $this->createClient();

        $this->markTestIncomplete('Silex publish correctly.');
        $this->markTestIncomplete("Dependencies::addBlocklyduinioAssets");
    }

    public function testBuilderCompiler() {

        $this->markTestIncomplete("post to compiler and check response");
    }

    public function testApp(){

        $this->markTestIncomplete('$app["codebender.get"]');
        $this->markTestIncomplete('$app["codebender"]');
        $this->markTestIncomplete('$app["codebender.builder"]');
    }

}