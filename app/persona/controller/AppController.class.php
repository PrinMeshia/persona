<?php

namespace app\persona\controller;
class AppController{
    public $boot;
    public function __construct(){
        $this->boot = $GLOBALS['boot'];
    }
    

}