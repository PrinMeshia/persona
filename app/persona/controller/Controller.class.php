<?php

namespace app\persona\controller;
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
    private  $persona;
    public function __construct($persona){
        $this->persona = $persona;
    }
    public function call($module, $action = "index",$vars = [])
    {
        $str = $this->persona->config->namespace->module.strtolower($module).'\\'.ucfirst(strtolower($module));
        if (class_exists($str) ) {
            $this->_controller = new $str($this->persona);
            $this->_action = $action.'Action';
            if(method_exists($this->_controller,$this->_action)){
                call_user_func_array(array($this->_controller, $this->_action),$vars);
            }else{
                $this->persona->response->error('Action '.$action.' not found',404);
            }
        }else{
            $this->persona->response->error('Controller '.$module.' not found',404);
        }
    }

}