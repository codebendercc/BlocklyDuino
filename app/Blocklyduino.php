<?php
// Blocklyduino.php

namespace app;

use DerAlex\Silex\YamlConfigServiceProvider;
use Silex\Application;

class Blocklyduino extends Application {

    /**
     * Add some traits that make our Application special
     */
    use Application\TwigTrait;
    use Application\UrlGeneratorTrait;

    /**
     * Instantiate a new Blocklyduino Application.
     * Objects and parameters can be passed as argument to the constructor.
     * @param array $values The parameters or objects.
     */
    function __construct(array $values = array()) {
        parent::__construct();

        // Most of our configuration is actually in this YAML file
        $this->register(new YamlConfigServiceProvider(__DIR__.'/../src/config/settings.yml'));

        // Set to false if you don't want debug messages
        $this['debug'] = $this['config']['debug']['is_on'];

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        Dependencies::configure($this);
        Routes::configure($this);
    }

    /**
     * Provides a JSON for debugging the builder. The file is specified by the ['debug']['code_file'] setting in config/settings.yml
     * @return string|null Either the contents of the JSON debugging file, or null if the file is not found
     */
    function getDebugFile() {
        $debugFile = __DIR__.'/../src/config/'.$this['config']['debug']['code_file'];
        $debugJSON = null;

        if(file_exists($debugFile)) {
            $debugJSON = file_get_contents($debugFile);
        }

        return $debugJSON;
    }

}
