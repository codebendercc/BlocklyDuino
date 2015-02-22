<?php
// Utilities.php

namespace app;

use GuzzleHttp\Client;
use codebender\blocklyduino\beans\BuilderResponse;


class Utilities {

    /**
     * Handles all our Guzzlin'. Sends a JSON-formatted request to the Builder service and returns the response.
     * @param string $url The Codebender Builder URL to post to
     * @param string $json The appropriately-escaped code to submit to the builder
     * @return BuilderResponse The results of the POST, parsed into an easier to use bean
     */
    static function postToBuilder($url, $json) {
        $client = new Client();
        $response = $client->post($url, ['body' => $json]);
        $builderResponse = new BuilderResponse($response->getBody());
        return $builderResponse;
    }

    /**
     * Handles all our fancy JSON wrangling in a consistent way. For some reason Silex wants to escape our input.
     * @param JsonSerializable $jsonable The data to format into JSON
     * @return string A properly formatted JSON string
     */
    static function formatJSON($jsonable) {
        return stripslashes(json_encode($jsonable, JSON_UNESCAPED_SLASHES));
    }

}