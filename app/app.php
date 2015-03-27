<?php
// app.php

// Add the autoloading mechanism of Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Create the Blocklyduino Silex application.
// The constructor handles all the default configuration.
$app = new app\Blocklyduino();

// Start the application, i.e. handle the request
$app->run();
