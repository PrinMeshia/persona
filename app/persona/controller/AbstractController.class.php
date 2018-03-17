<?php

namespace app\persona\controller;
use app\persona\helpers\Helpers;
use app\persona\Persona;
class AbstractController{
    protected $request;
    private $filename = '%s/view/%s';
    
    public function __construct(){
        $this->persona = Persona::getInstance();
        $this->request = Persona::getInstance()->getRequest();
        
        $this->filename = sprintf($this->filename, Helpers::getDirectory(get_called_class()),Persona::getInstance()->request->action);
    }
    protected function render(array $vars = [])
    {
        Persona::getInstance()->response->response($this->filename,$vars);
    }
    

}


