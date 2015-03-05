<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Add the autoloading mechanism of Composer

// Create the Silex application, in which all configuration is going to go
$app = new Silex\Application();

// Set to false if you don't want debug messages
$app['debug'] = true;

// The URL to use to connect to the Codebender Builder service
$app['builder_url'] = "http://builder.codebender.cc:8080/compile?api_key=blocklyduino";

// An example JSON request for testing the service connection
$app['debug_code_request'] = <<<HDOC
{"files":[{"filename":"Blink Example.ino","content":"\/*\\n\\tBlink\\n\\tTurns on an LED on for one second, then off for one second, repeatedly.\\n\\n\\tThis example code is in the public domain.\\n*\/\\n\\nvoid setup()\\n{\\n\\t\/\/ initialize the digital pin as an output.\\n\\t\/\/ Pin 13 has an LED connected on most Arduino boards:\\n\\tpinMode(13, OUTPUT);\\n}\\n\\nvoid loop()\\n{\\n\\tdigitalWrite(13, HIGH); \/\/ set the LED on\\n\\tdelay(1000); \/\/ wait for a second\\n\\tdigitalWrite(13, LOW); \/\/ set the LED off\\n\\tdelay(1000); \/\/ wait for a second\\n}\\n"}],"libraries":[],"logging":true,"format":"binary","version":"105","build":{"mcu":"atmega328p","f_cpu":"16000000L","core":"arduino","variant":"standard"}}
HDOC;

app\Dependencies::configure($app);
app\Routes::configure($app);

// This should be the last line
$app->run(); // Start the application, i.e. handle the request
