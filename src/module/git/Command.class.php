<?php
/**
 * 
 */
namespace src\module\git;
use app\persona\controller\AbstractController;
class Command extends AbstractController
{
    public function indexAction(){
        echo "toto";
        return parent::render();
    }
}