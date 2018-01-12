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
    private static $_core;
    public function __construct($core){
        self::$_core = $core;
    }
    public function call($module, $action = "index",$vars = array())
    {
        $str = 'src\\modules\\'.$module.'\\'.ucfirst($module);
        if (class_exists($str) ) {
            $this->_controller = new $str($this);
            $this->_action = $action.'Action';
            if(method_exists($this->_controller,$this->_action)){
                call_user_func_array(array($this->_controller, $this->_action),$vars);
            }else{
                self::$_core->response->error('Action '.$action.' not found',404);
            }
        }else{
            self::$_core->response->error('Module '.$module.' not found',404);
        }
    }

}