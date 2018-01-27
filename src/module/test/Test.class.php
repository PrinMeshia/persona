<?php
/**
 * 
 */
namespace src\module\test;
use app\persona\controller\AppController;
class Test extends AppController
{
    public function indexAction(){
        $this->persona->response->ResponseHTML('<h1> HELL WORLD </h1>');
    }
}
