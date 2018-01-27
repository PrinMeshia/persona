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
    private  $personna;
    public function __construct($personna){
        $this->personna = $personna;
    }
    public function call($module, $action = "index",$vars = array())
    {
        $str = $this->personna->config->namespace->module.strtolower($module).'\\'.ucfirst(strtolower($module));
        if (class_exists($str) ) {
            $this->_controller = new $str($this->personna);
            $this->_action = $action.'Action';
            if(method_exists($this->_controller,$this->_action)){
                call_user_func_array(array($this->_controller, $this->_action),$vars);
            }else{
                $this->personna->response->error('Action '.$action.' not found',404);
            }
        }else{
            $this->personna->response->error('Module '.$module.' not found',404);
        }
    }

}