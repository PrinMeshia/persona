<?php

namespace app\persona\core;
abstract class Core
{
    protected static $objects = [];
    protected static $conf = [];
    protected $routes = [];
    public $allocatedSize = [];

    protected function __construct(){}
    public abstract function run();
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
        $this->InitEnvVar();
        $this->config->load('/app/config/environment/'.$_ENV.'.json');
        $this->session->start();
        $this->debug;
    }
    protected function InitEnvVar(){
        $_ENV = $this->environment->setEnvironment('/app/config/environment.json');
        $_SESSION["DEBUG"] = [];
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

}