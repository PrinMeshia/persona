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
    private $get;
    private $post;
    private $files;
    private $server;
    private $cookie;
    private $method;
    private $requested_uri;
    public function __construct(){
        $this->createFromGlobals();
    }

    private function createFromGlobals(){
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $this->requested_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/' ;
    }
    public function get($key){
        return isset($this->get[$key]) ? $this->get[$key] : false;
    }
    public function post($key){
        return isset($this->post[$key]) ? $this->post[$key] : false;
    }
    public function server($key){
        return isset($this->server[$key]) ? $this->server[$key] : false;
    }
    public function cookie($key){
        return isset($this->cookie[$key]) ? $this->cookie[$key] : false;
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
}