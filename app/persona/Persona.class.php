<?php
namespace app\persona;
use app\persona\route\Route;
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 12:09
 * file : Bootstrap.class.php
 * description :
 */
class Persona extends core\Core
{

    private static $_instance  = null;
    
    public function __construct(){
        
        parent::__construct();
        $this->storeCoreObjects();
        $this->loadRoute();
    }
    public static function singleton(){
        if (self::$_instance == NULL) {
            self::$_instance = new self();
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
        if(is_array($method))
            foreach ($method as $value) {
               $this->routes[$value][] = new Route($uri, $callback);
            }
        else
            $this->routes[$method][] = new Route($uri, $callback);
        
    }
    public function loadRoute(){
        $persona = $this;
        if($this->config->routing){
            $path = ROOT.$this->config->routing->path;
            if(file_exists($path) && is_readable( $path )){
                $content = json_decode(file_get_contents($path,TRUE));
                foreach ($content->routes as $key => $value) {
                    $action = explode("#",$value->module);
                    $persona->createRoute($value->route,$value->method, function() use ($persona,$action){
                        $persona->controller->call($action[0],sizeof($action)>1?$action[1]:"index");
                    });

                }
                
            } 
        }
    }

    /**
     * @return bool
     */
    public function listen(){
        $slugs = array();
        $run = $this->router->traverseRoutes($this->request->getMethod(), $this->routes, $slugs);
        if(!$run && (!isset($this->routes['RESPOND']) || empty($this->routes['RESPOND'])) && !$this->config->messages->e404){
            return $this->response->error("Route not found for Path: '{$this->request->getRequestedUri()}' with HTTP Method: '{$this->request->getMethod()}'. ", 404 );
        }
        else if(!$run && (isset($this->routes['RESPOND']) && !empty($this->routes['RESPOND']))){
            $callback = $this->routes['RESPOND'][0]->function;
            call_user_func($callback);
        }else if(!$run && $this->config->messages->e404){
            $this->response->error($this->config->messages->e404, 404 ) ;
        }
        if($this->config->environment->{$this->config->system->currentEnv}->debug == 'full')
            echo $this->profiler->display();   
        return true;
    }
    public function getRoutes(){
        return $this->routes;
    }
}
