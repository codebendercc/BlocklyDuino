<?php
// Blocklyduino.php

namespace app;

use Silex\Application;

class Blocklyduino extends Application {
    use Application\TwigTrait;
    use Application\UrlGeneratorTrait;

    /**
     * Instantiate a new Blocklyduino Application.
     *
     * Objects and parameters can be passed as argument to the constructor.
     *
     * @param array $values The parameters or objects.
     */
    function __construct(array $values = array()) {
        parent::__construct();

        // Set to false if you don't want debug messages
        $this['debug'] = true;

        // The URL to use to connect to the Codebender Builder service
        $this['builder_url'] = "http://builder.codebender.cc:8080/compile?api_key=blocklyduino";

        // An example JSON request for testing the service connection
        $this['debug_code_request'] = <<<HDOC
{"files":[{"filename":"Blink Example.ino","content":"\/*\\n\\tBlink\\n\\tTurns on an LED on for one second, then off for one second, repeatedly.\\n\\n\\tThis example code is in the public domain.\\n*\/\\n\\nvoid setup()\\n{\\n\\t\/\/ initialize the digital pin as an output.\\n\\t\/\/ Pin 13 has an LED connected on most Arduino boards:\\n\\tpinMode(13, OUTPUT);\\n}\\n\\nvoid loop()\\n{\\n\\tdigitalWrite(13, HIGH); \/\/ set the LED on\\n\\tdelay(1000); \/\/ wait for a second\\n\\tdigitalWrite(13, LOW); \/\/ set the LED off\\n\\tdelay(1000); \/\/ wait for a second\\n}\\n"}],"libraries":[],"logging":true,"format":"binary","version":"105","build":{"mcu":"atmega328p","f_cpu":"16000000L","core":"arduino","variant":"standard"}}
HDOC;

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        Dependencies::configure($this);
        Routes::configure($this);
    }

}
