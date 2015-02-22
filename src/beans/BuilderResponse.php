<?php
// BuilderResponse.php

namespace codebender\blocklyduino\beans;

class BuilderResponse {

    protected $success;
    protected $time;
    protected $size;
    protected $output;
    protected $log;
    protected $additionalCode;
    protected $raw;

    function __construct($jsonResponse){
        $request = json_decode($jsonResponse, true);
        $this->success = boolval($request["success"]);
        $this->time = floatval($request["time"]);
        $this->size = strval($request["size"]);
        $this->output = strval($request["output"]);
        $this->log = strval($request["log"]);
        $this->additionalCode = $request["additionalCode"];
        $this->raw = $jsonResponse;
    }

    /**
     * Indicates whether the compilation was successful or not
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * The time spent on the compilation process (not including time spent for connections, etc)
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * The size of the binary file output in bytes
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * The actual binary output produced during the compilation in BASE-64 encoding
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * If the logging option was set to true, this key should exist and it's value would be a list of the avr-gcc calls made during the compilation
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Lists the libraries that were fetched/used during the compilation
     * @return mixed
     */
    public function getAdditionalCode()
    {
        return $this->additionalCode;
    }

    /**
     * The raw JSON formatted response provided to build this particular instance of the class
     * @return string
     */
    public function getRaw() {
        return $this->raw;
    }
}