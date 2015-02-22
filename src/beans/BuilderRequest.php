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
//        $this->build = [
//            'mcu' => 'atmega328p',
//            'f_cpu' => '16000000L',
//            'core' => 'arduino',
//            'variant' => 'standard'
//        ];
        $this->build = new BuildData();
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
            'build' => $this->build->toArray()
            //'build' => $this->build
        );
    }
}

class BuildData implements \JsonSerializable {

    protected $mcu;
    protected $f_cpu;
    protected $core;
    protected $variant;
    protected $vid;
    protected $pid;



    // TODO: Refactor this when we're ready to pass in these values
    function __construct(){
        $this->mcu = 'atmega328p';
        $this->f_cpu = '16000000L';
        $this->core = 'arduino';
        $this->variant = 'standard';
    }

    /**
     * Processor's MCU spec
     * @return string
     */
    public function getMcu()
    {
        return $this->mcu;
    }

    /**
     * Sets processor's MCU spec
     * @param string $mcu
     */
    public function setMcu($mcu)
    {
        $this->mcu = $mcu;
    }

    /**
     * Processor's clock speed F_CPU spec
     * @return string
     */
    public function getFCpu()
    {
        return $this->f_cpu;
    }

    /**
     * Sets processor's clock speed F_CPU spec
     * @param string $f_cpu
     */
    public function setFCpu($f_cpu)
    {
        $this->f_cpu = $f_cpu;
    }

    /**
     * Arduino core used for the board
     * @return string
     */
    public function getCore()
    {
        return $this->core;
    }

    /**
     * Sets Arduino core used for the board
     * @param string $core
     */
    public function setCore($core)
    {
        $this->core = $core;
    }

    /**
     * Variant used for the board
     * @return string
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Sets variant used for the board
     * @param string $variant
     */
    public function setVariant($variant)
    {
        $this->variant = $variant;
    }

    /**
     * USB VID (optional, for Leonardo-like USB-enabled devices)
     * @return string
     */
    public function getVid()
    {
        return $this->vid;
    }

    /**
     * Sets USB VID (optional, for Leonardo-like USB-enabled devices)
     * @param string $vid
     */
    public function setVid($vid)
    {
        $this->vid = $vid;
    }

    /**
     * USB VID (optional, for Leonardo-like USB-enabled devices)
     * @return string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Sets USB VID (optional, for Leonardo-like USB-enabled devices)
     * @param string $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * The BuilderRequest as an array
     * @return array this
     */
    function toArray()
    {
        $arr = [
            'mcu' => $this->mcu,
            'f_cpu' => $this->f_cpu,
            'core' => $this->core,
            'variant' => $this->variant
        ];

        // $pid and $vid are optional parameters
        if($this->pid != null) {
            $arr['pid'] = $this->pid;
        }

        if($this->vid != null) {
            $arr['vid'] = $this->vid;
        }

        return $arr;
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
        return $this->toArray();
    }
}