<?php

namespace app\persona\core;
abstract class Core
{
    protected static $objects = array();
    protected static $conf = array();
    protected $routes = array();
    public $btrace = array();
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
        $this->session = 'app\\persona\\session\\Session';
        $this->config = 'app\\persona\\config\\Config';
        $this->config->load('/app/config/persona.json');
        $this->config->loadUserConfig($this->config->config);
        $this->environnement = $this->config->namespace->persona.'config\\Environment';
        $this->response = $this->config->namespace->persona.'http\\Response';
        new \app\persona\debug\Debug($this);
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
}