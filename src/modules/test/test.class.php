<?php
/**
 * 
 */
namespace src\modules\test;
use app\persona\controller\AppController;
class Test extends AppController
{
    public function indexAction(){
        $this->boot->response->ResponseHTML('<p> This is a response with code 404. </p>', 404);
    }
}
