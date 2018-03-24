<?php

namespace app\persona\controller;
use app\persona\helpers\Helpers;
use app\persona\Persona;
class AbstractController{
    protected $request;
    private $filename = '%s/rsc/view/%s';
    private $csspath = '%s/rsc/css/%s.css';
    private $jspath = '%s/rsc/js/%s.js';
    
    public function __construct(){
        $action = isset(Persona::getInstance()->request->p)?Persona::getInstance()->request->p:"index";
        $this->persona = Persona::getInstance();
        $this->request = Persona::getInstance()->getRequest();
        $this->filename = sprintf($this->filename, Helpers::getDirectory(get_called_class()),$action);
        $this->csspath = sprintf($this->csspath, Helpers::getDirectory(get_called_class()),$action);
        $this->jspath = sprintf($this->jspath, Helpers::getDirectory(get_called_class()),$action);
    }
    protected function render(array $vars = [])
    {
        Persona::getInstance()->ressources->assignCssFile($this->csspath);
        Persona::getInstance()->ressources->assignJsFile($this->jspath);
        Persona::getInstance()->response->response($this->filename,$vars);
    }
    

}


