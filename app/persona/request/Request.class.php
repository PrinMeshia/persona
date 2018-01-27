<?php
namespace app\persona\request;
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 13:45
 * Project : a10t2
 * file : Request.class.php
 * description :
 */
class Request
{
    private $_data;
    private $server;
    private $cookie;
    private $method;
    private $origin;
    private $requested_uri;
    public function __construct(){
        $this->createFromGlobals();
    }
    public function __get($name)
	{
		return (isset($this->_data[$name])) ? ($this->_data[$name]) : (NULL) ;
	}
	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}
	public function __isset($name)
	{
	    return isset($this->_data[$name]);
	}
    private function createFromGlobals(){
        $this->_data = $_REQUEST;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $this->requested_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/' ;
        $this->origine = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : FALSE;
    }
    public function get($key){
        return (isset($_GET[$key])) ? ($_GET[$key]) : FALSE;
    }
    public function post($key){
        return (isset($_POST[$key])) ? ($_POST[$key]) : FALSE;
    }
    public function server($key){
        return isset($this->server[$key]) ? $this->server[$key] : FALSE;
    }
    public function cookie($key){
        return isset($this->cookie[$key]) ? $this->cookie[$key] : FALSE;
    }
    public function getBody(){
        if ($this->body == null)
            $this->body = file_get_contents('php://input');
        return $this->body;
    }
    public function header($key){
        return isset($_SERVER['HTTP_'.strtoupper($key)]) ? $_SERVER['HTTP_'.strtoupper($key)] : false;
    }
    public function getMethod(){
        return $this->method;
    }
    public function  getRequestedUri(){
        return $this->requested_uri;
    }
    public function clear($value){
        return htmlentities($value);
    }
}