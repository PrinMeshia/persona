<?php
namespace app\persona;
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 12:09
 * file : Bootstrap.class.php
 * description :
 */
 use \app\persona\helpers\Helpers;
 use \app\persona\route\Route;
class Persona extends registry\Registry
{

    private static $_instance;
    public function __construct(){
        parent::__construct();
        if($this->config->currentEnv != ''){
            $this->storeCoreObjects();
        }
        
    }
    public static function singleton(){
        if(!self::$_instance) {
            self::$_instance = new Persona();
        }
        return self::$_instance;
    }
    public function getRootDir()
    {
        return __DIR__;
    }
        /**
         * @param $uri
         * @param $method (GET,POST,PUT,DELETE,RESPOND)
         * @param callable $callback
         * create route
         */
    public function createRoute($uri = '',$method,callable $callback){
        $this->routes[$method][] = new Route($uri, $callback);
    }

    /**
     * @return bool
     */
    public function listen(){
        $slugs = array();
        $run = $this->router->traverseRoutes($this->request->getMethod(), $this->routes, $slugs);
        if(!$run && (!isset($this->routes['respond']) || empty($this->routes['respond']))){
            return $this->response->error("Route not found for Path: '{$this->request->getRequestedUri()}' with HTTP Method: '{$this->request->getMethod()}'. ", 1 );
        }
        else if(!$run){
            $this->routes['respond']->function();
        }
        return true;
    }
    public function getRoutes(){
        return $this->routes;
    }
}
