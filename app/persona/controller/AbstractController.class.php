<?php

namespace app\persona\controller;
use app\persona\helpers\Helpers;
use app\persona\Persona;
class AbstractController{
    protected $request;
    private $filename = '%s/rsc/view/%s';
    private $csspath = '%s/rsc/css/%s.css';
    private $jspath = '%s/rsc/js/%s.js';
    protected $persona = "";
    protected $reponse = "";
    protected static $model = [];
    private $data = [];
    function __set($index, $value)
    {

        self::$model[ $index ] = new $value();
    }
 
    function __get($index)
    {
        if(!isset(self::$model[ $index ])){
            $this->$index = $this->persona->config->namespace->model.ucfirst($index);
        }
        if( is_object ( self::$model[ $index ] ) )
            return self::$model[ $index ];
    }

    public function __construct(){
        $action = isset(Persona::getInstance()->request->p)?Persona::getInstance()->request->p:"index";
        $this->persona = Persona::getInstance();
        $this->reponse = Persona::getInstance()->response;
        $this->request = Persona::getInstance()->getRequest();
        $this->filename = sprintf($this->filename, Helpers::getDirectory(get_called_class()),$action);
        $this->csspath = sprintf($this->csspath, Helpers::getDirectory(get_called_class()),$action);
        $this->jspath = sprintf($this->jspath, Helpers::getDirectory(get_called_class()),$action);
    }
    public function render()
    {
        var_dump($this->data);
        Persona::getInstance()->ressources->assignCssFile($this->csspath);
        Persona::getInstance()->ressources->assignJsFile($this->jspath);
        $this->reponse->response($this->filename,$this->data);
        
    }
    public function assign(array $data){
        $this->data = array_merge($this->data, $data);
    }
    public function __call($method,$arguments) {
        echo "test";
        //call_user_func_array(array($this,$method),$arguments);
        
    }
    

}


