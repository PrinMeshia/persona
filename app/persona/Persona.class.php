<?php
namespace app\persona;


use app\persona\route\Route;

class Persona extends core\Core
{
    protected function __construct()
    {
    }
    private static $_instances = null;
    public static function getInstance()
    {
        if (self::$_instances === null) {
            ob_start();
            self::$_instances = new self();
        }
        return self::$_instances;
    }
    public function getRootDir()
    {
        return __DIR__;
    }
    public function redirect($uri){
        header('Location: '.$uri); 
    }
    public function run()
    {
        $this->init();
        $this->setTimezone();
        $this->listen();
    }
 
    public function listen()
    {
        if($this->config->system->maintenance){
            if($_SERVER['REQUEST_URI'] == Persona::getInstance()->config->rootfolder.'/'){
                $this->response->maintenance();
            }else{
                $this->redirect(Persona::getInstance()->config->rootfolder.'/');
            }
        }else{
            $this->router->route();
        }
    }
    public function generateRoute($uri){
        return ($this->config->root) ?($this->config->root.$uri) : $uri;
    }
   
}
