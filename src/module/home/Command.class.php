<?php
/**
 * 
 */
namespace src\module\home;
use app\persona\controller\AbstractController;
class Command extends AbstractController
{
    public function indexAction(){
        
        return parent::render();
    }
}
