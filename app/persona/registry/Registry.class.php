<?php

namespace app\persona\registry;
abstract class Registry
{
    protected static $objects = array();
    protected static $conf = array();
    protected $routes = array();
    public function __construct(){
        $this->config = 'app\\persona\\config\\Config';
        $this->config->load(ROOT.'/app/config/persona.json');
    }
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
    protected function storeCoreObjects()
    {

        $this->request = 'app\\persona\\request\\Request';
        $this->router = 'app\\persona\\route\\Router';
        $this->db = 'app\\persona\\database\\Database';
        $this->response = 'app\\persona\\response\\Response';
        $this->controller = 'app\\persona\\controller\\Controller';
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