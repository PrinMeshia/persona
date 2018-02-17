<?php

namespace app\persona\controller;
use app\persona\helpers\Helpers;
class AbstractController{
    protected $persona;
    protected $request;
    private $filename = '%s/view/%s';
    
    public function __construct($persona){
        $this->persona = $persona;
        $this->request = $persona->getRequest();
        $this->persona->view = 'app\\persona\\view\\View';
        $this->filename = sprintf($this->filename, Helpers::getDirectory(get_called_class()),$persona->request->action);
    }
    protected function render(array $vars = [])
    {
        $this->persona->response->response($this->filename,$vars);
    }
    

}


