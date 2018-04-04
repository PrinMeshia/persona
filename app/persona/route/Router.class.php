<?php
namespace app\persona\route;

use app\persona\Persona;
use app\persona\GlobalRepository;

class Router
{

    private $controller;
    private $method;
    private $params = [];
    public function __construct()
    {
        $this->controller = Persona::getInstance()->config->default->controller . '\\Command';
        $this->method = Persona::getInstance()->config->default->method . 'Action';
    }

    public function route()
    {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (Persona::getInstance()->config->rootfolder . '/' != '/') {
            $path = trim(substr($path, strlen(Persona::getInstance()->config->rootfolder . '/')), '/');
        } else {
            $path = trim($path, '/');
        }
        @list($controller, $method, $params) = array_filter(explode('/', $path, 3));

        if (isset($controller)) {
            $obj = Persona::getInstance()->config->namespace->module . strtolower($controller) . '\\Command';
            if (class_exists($obj)) {
                $this->controller = $obj;
            } else {
                return $this->notFound();
            }
            unset($controller);
        }
        $method .= "Action";
        if (isset($method)) {
            if (method_exists($this->controller, $method) && !method_exists(get_parent_class($this->controller), $method)) {
                $this->method = $method;
            } else {
                return $this->notFound();
            }
            unset($method);
        }
       if (method_exists($this->controller, $this->method)) {
        call_user_func_array([new $this->controller(), $this->method], $this->params);
        } else {
            return $this->notFound();
        }
        unset($params);
        
    }
    private function notFound()
    {
        if(Persona::getInstance()->config->debug && Persona::getInstance()->config->debug == 2)
            $msg = "Route not found for Path: '" . Persona::getInstance()->request->getRequestedUri() . "' with HTTP Method: '" . Persona::getInstance()->request->getMethod() . "'. ";
        else
            $msg = Persona::getInstance()->config->messages->e404 ? Persona::getInstance()->config->messages->e404 : "";
        return Persona::getInstance()->response->error($msg, 404);
    }
}


