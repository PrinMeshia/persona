<?php

namespace app\persona\core;
abstract class Core
{
    protected static $objects = [];
    protected static $conf = [];
    protected $routes = [];
    public $btrace = [];
    private $_env;
    public $allocatedSize = [];

    protected function __construct(){}
    public abstract function run();
    public abstract function loadRoute();
    public abstract function createRoute($uri,$method, callable $callback);
    public abstract  function listen();



    function __set($index, $value)
    {
        self::$objects[ $index ] = new $value();
    }

    /**
     * @param $index
     * @return mixed
     */
    function __get($index)
    {
        if(!isset(self::$objects[ $index ])){
            if($this->config->class->{$index}){
                $this->$index = $this->config->class->{$index};
            }
        }
        if( is_object ( self::$objects[ $index ] ) )
            return self::$objects[ $index ];
    }

    /**
     * @param $index
     */
    function __unset($index)
    {
        if( is_object ( self::$objects[ $index ] ) )
            unset(self::$objects[ $index ]);
    }

   
    protected function init(){

        $this->config = 'app\\persona\\config\\Config';
        $this->config->load('/app/config/persona.json');
        $this->config->load('/app/config/environment/'.$this->getCurrentEnv().'.json');
        $this->session->start();
        $this->debug;
    }
    public function getRequest(){
        return $this->request;
    }
    public function setStatusCode($status = 200){
        if ($status != 200)
            http_response_code($status);
        return $status;
    }
    public function setTimezone(){
        date_default_timezone_set($this->config->system->timezone ? $this->config->system->timezone : "UTC" );
    }
    public function getCurrentEnv(){
        if(!isset($_ENV["PERSONA"]) || !empty($_ENV["PERSONA"]))
            $this->environment->setEnvironment('/app/config/environment.json');
        return $_ENV["PERSONA"];
    }

}