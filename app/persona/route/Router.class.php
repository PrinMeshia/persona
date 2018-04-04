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
        var_dump("init router");
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
                $this->notFound();
                exit(1);
            }
            unset($controller);
        }
        
        if (isset($method)) {
            $realmethod = $method."Action";
            if (method_exists($this->controller, $realmethod) && !method_exists(get_parent_class($this->controller), $realmethod)) {
                $this->method = $realmethod;
            } else {
                $this->notFound();
                exit(1);
            }
            unset($method);
            unset($realmethod);
        }
        if (method_exists($this->controller, $this->method)) {
            call_user_func_array([new $this->controller(), $this->method], $this->params);
        } else {
            $this->notFound();
                exit(1);
        }
        unset($params);

    }
    private function notFound()
    {
        if (Persona::getInstance()->config->debug && Persona::getInstance()->config->debug == 2)
        $msg = "Route not found for Path: '" . Persona::getInstance()->request->getRequestedUri() . "' with HTTP Method: '" . Persona::getInstance()->request->getMethod() . "'. ";
        else
            $msg = Persona::getInstance()->config->messages->e404 ? Persona::getInstance()->config->messages->e404 : "";
        Persona::getInstance()->response->error($msg, 404);
    }
}


