<?php
// BuilderRequest.php

namespace codebender\blocklyduino\beans;

class BuilderRequest implements \JsonSerializable
{

    protected $files;
    protected $libraries;
    protected $logging;
    protected $format;
    protected $version;
    protected $build;

    // We'll probably need to expand the number of parameters
    // that this accepts sometime soon...
    function __construct($code){
        $this->files = [
            [
                'filename' => "sketch.ino",
                'content' => $code
            ]
        ];
        $this->libraries = array();
        $this->logging = true;
        $this->format = "binary";
        $this->version = "105";
        $this->build = [
            'mcu' => 'atmega328p',
            'f_cpu' => '16000000L',
            'core' => 'arduino',
            'variant' => 'standard'
        ];
    }

    /**
     * Contains an array of the files to be compiled, with one record for each file
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Contains an array of the libraries used by the sketch, with their corresponding files
     * @return array
     */
    public function getLibraries()
    {
        return $this->libraries;
    }

    /**
     * Whether to use logging or not
     * @return boolean
     */
    public function isLogging()
    {
        return $this->logging;
    }

    /**
     * Contains the output format you would like to request from the compiler
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Contains the Arduino SDK version that your code will be built with
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Contains the build parameters for the selected board configuration,
     * which the ones found in the original boards.txt configuration files
     * under the board_name.build.* parameters.
     * @return array
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return array(
            'files' => $this->files,
            'libraries' => $this->libraries,
            'logging' => $this->logging,
            'format' => $this->format,
            'version' => $this->version,
            'build' => $this->build
        );
    }
}