<?php

namespace app\persona\controller;

use app\persona\Persona;

class Controller{
    public $conf;
    public $view;
    public $table;
    public $id;
    public $db;
    public $userValidate;
    protected $_model;
    protected $_controller;
    protected $_action;
    public function __construct(){}
    public function call($module, $action = "index",$vars = [])
    {
        $str = Persona::getInstance()->config->namespace->module.strtolower($module).'\\'.ucfirst(strtolower($module));
        var_dump($str);
        if (class_exists($str) ) {
            $this->_controller = new $str();
            $this->_action = $action.'Action';
            if(method_exists($this->_controller,$this->_action)){
                call_user_func_array(array($this->_controller, $this->_action),$vars);
            }else{
                Persona::getInstance()->response->error('Action '.$action.' not found',404);
            }
        }else{
            Persona::getInstance()->response->error('Controller '.$module.' not found',404);
        }
    }

}