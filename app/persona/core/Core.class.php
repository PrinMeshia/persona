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
    public function __construct(){
        $this->init();
    }
    public abstract function loadRoute();
    public abstract function createRoute($uri,$method, callable $callback);
    public abstract  function listen();
    function __set($index, $value)
    {
        self::$objects[ $index ] = new $value($this);
    }
    function __get($index)
    {
        if( is_object ( self::$objects[ $index ] ) )
            return self::$objects[ $index ];
    }
    function __unset($index)
    {
        if( is_object ( self::$objects[ $index ] ) )
            unset(self::$objects[ $index ]);
    }

    protected function init(){
        $this->response = 'app\\persona\\http\\Response';
        $this->environment = 'app\\persona\\config\\Environment';
        $this->environment->setEnvironment('/app/config/environment.json');
        $this->session = 'app\\persona\\session\\Session';
        $this->config = 'app\\persona\\config\\Config';
        $this->config->load(['/app/config/persona.json','/app/config/environment/'.$this->getCurrentEnv().'.json']);
        $this->debug = $this->config->namespace->persona.'debug\\Debug';
    }
    protected function storeCoreObjects()
    {
        $this->router = $this->config->namespace->persona.'route\\Router';
        $this->request = $this->config->namespace->persona.'request\\Request';
        $this->db = $this->config->namespace->persona.'database\\Database';
        $this->controller = $this->config->namespace->persona.'controller\\Controller';
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
        if($this->config->system->timezone)
            date_default_timezone_set($this->config->system->timezone);
        else
        date_default_timezone_set("UTC");
    }
    public function setCurrentEnv($env){
        $this->_env = $env;
    }
    public function getCurrentEnv(){
        return $this->_env;
    }
}