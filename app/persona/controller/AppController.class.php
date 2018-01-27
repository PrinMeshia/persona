<?php

namespace app\persona\controller;
class AppController{
    protected $persona;
    protected $request;
    private $layout;
    public function __construct($persona){
        $this->persona = $persona;
        $this->request = $persona->getRequest();
        $this->layout = $persona->config->layout->name;
    }
    protected function render($view,$vars = [],$tpl = null)
    {
        if(is_null($tpl)){
            $layout = $this->layout;
        }else{
            $layout = $tpl;
        }
        $persona->view->load($view,$vars,$layout);
    }

}