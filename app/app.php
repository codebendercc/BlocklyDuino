<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Add the autoloading mechanism of Composer

// Includes
use codebender\blocklyduino\beans;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @param string $url The Codebender Builder URL to post to
 * @param string $code The JSON-formatted code to submit to the builder
 * @return BuilderResponse The results of the POST, parsed into an easier to use bean
 */
function postToBuilder($url, $json) {
    $client = new GuzzleHttp\Client();
    $response = $client->post($url, ['body' => $json]);
    $builderResponse = new codebender\blocklyduino\beans\BuilderResponse($response->getBody());
    return $builderResponse;
}

$app = new Silex\Application(); // Create the Silex application, in which all configuration is going to go

// Set to false if you don't want debug messages
$app['debug'] = true;

// The URL to use to connect to the Codebender Builder service
$app['builder_url'] = "http://builder.codebender.cc:8080/compile?api_key=blocklyduino";

// An example JSON request for testing the service connection
$app['debug_code_request'] = "{\"files\":[{\"filename\":\"Blink Example.ino\",\"content\":\"\/*\\n\\tBlink\\n\\tTurns on an LED on for one second, then off for one second, repeatedly.\\n\\n\\tThis example code is in the public domain.\\n*\/\\n\\nvoid setup()\\n{\\n\\t\/\/ initialize the digital pin as an output.\\n\\t\/\/ Pin 13 has an LED connected on most Arduino boards:\\n\\tpinMode(13, OUTPUT);\\n}\\n\\nvoid loop()\\n{\\n\\tdigitalWrite(13, HIGH); \/\/ set the LED on\\n\\tdelay(1000); \/\/ wait for a second\\n\\tdigitalWrite(13, LOW); \/\/ set the LED off\\n\\tdelay(1000); \/\/ wait for a second\\n}\\n\"}],\"libraries\":[],\"logging\":true,\"format\":\"binary\",\"version\":\"105\",\"build\":{\"mcu\":\"atmega328p\",\"f_cpu\":\"16000000L\",\"core\":\"arduino\",\"variant\":\"standard\"}}";

// Dependencies:
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Routes:

// /
$app->get('/', function (Silex\Application $app)  { // Match the root route (/) and supply the application as argument
    return $app['twig']->render(
        'blockly.html.twig',
        array('code' => "") // Just passing this in as a sort of placeholder for now. May not actually need it.
    );
})->bind('blockly');

// /compile
$app->post('/compile', function (Request $request) use ($app)  { // The code will be sent in via the request body

    //$code = $app['debug_code_request']; // Handy debug code
    $code = new codebender\blocklyduino\beans\BuilderRequest($request->getContent());

    // Guzzle it and get the results
    $builderResponse = postToBuilder($app['builder_url'], json_encode($code, JSON_UNESCAPED_SLASHES));

    // This route (or at least the return value of it)  will probably need to change in order to pass things back to the JavaScript layer
    return $app['twig']->render(
        'compile.html.twig',
        array(
            'request' => json_encode($code, JSON_UNESCAPED_SLASHES),
            'response' => $builderResponse->getRaw()
        )
    );
})->bind('compile'); // name the route so it can be referred to later in the section 'Generating routes'

// Views
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views', // The path to the templates, which is in our case points to /var/www/views
));

// This should be the last line
$app->run(); // Start the application, i.e. handle the request
