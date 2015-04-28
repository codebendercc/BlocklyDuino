<?php

namespace codebender\blocklyduino\tests\unit\services;

use codebender\blocklyduino\tests\unit\BlocklyduinoTestCase;

class CodebenderServiceProviderTest extends BlocklyduinoTestCase {

    protected $simplePayload = <<<'PAYLOAD'
{
  "files":
  [
    {
      "filename":"Blink Example.ino",
      "content":"void setup() {} void loop() {}"
    }
  ],
  "libraries":[],
  "logging":true,
  "format":"binary",
  "version":"105",
  "build":
    {
      "mcu":"atmega328p",
      "f_cpu":"16000000L",
      "core":"arduino",
      "variant":"standard"
    }
}
PAYLOAD;

    /**
     * @group builder_service
     */
    public function testPostFail(){
        $client = $this->createClient();
        $crawler = $client->request('POST', '/builder/compile', array(), array(), array(), '');
        $this->assertJsonStringEqualsJsonString('{"success":false,"message":"Invalid input."}', $client->getResponse()->getContent());
    }

    /**
     * @group builder_service
     */
    public function testPostSucceed(){
        $client = $this->createClient();
        $crawler = $client->request('POST', '/builder/compile', array(), array(), array(), $this->simplePayload);
        $builderSuccess = json_decode($client->getResponse()->getContent())->success;
        $this->assertEquals(true, $builderSuccess);
    }

}