<?php
/**
 * 
 */
namespace src\module\git;
use app\persona\controller\AbstractController;
class Command extends AbstractController
{
    public function indexAction(){
        $this->assign(["test"=>"toto"]);
        $this->render();
    }
}
