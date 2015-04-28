<?php

namespace codebender\blocklyduino\tests\unit\loading;

use codebender\blocklyduino\tests\unit\BlocklyduinoTestCase;

class AssetsTest extends BlocklyduinoTestCase {

    /**
     * @group assets
     */
    public function testAssetsAvailable() {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $content = $client->getResponse()->getContent();
        $this->assertContains('<link href="' . $this->app['asset_path'] . '/images/favicon.ico" rel="shortcut icon" />', $content);
        $this->assertContains('<link rel="stylesheet" type="text/css" href="' . $this->app['asset_path'] . '/css/main.css" />', $content);
    }

}