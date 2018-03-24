<?php
/**
 * 
 */
namespace src\module\test;
use app\persona\controller\AbstractController;
class Test extends AbstractController
{
    public function indexAction(){
        return parent::render();
    }
    public function oldindexAction(){
        $this->persona->response->ResponseHTML('<h1> HELL WORLD </h1>');
    }
    public function testAction(){
    
        return parent::render(
            [
                "part" => "test page via template"
            ]
        );
    }
    public function guideAction(){
    
        return parent::render(
            [
                "part" => "test page via template"
            ]
        );
    }
}
