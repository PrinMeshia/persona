<?php
/**
 * 
 */
namespace src\module\index;
use app\persona\controller\AbstractController;
class Index extends AbstractController
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
    public function pushRegisterAction(){
        $content = $this->request->getBody();
        $data = json_decode($content);
        $this->reponse->JsonResponse($data);
        // if (isset($data->endpoint)){
        //     $endpoint = $data->endpoint;
        // }else{
        //     throw new Exception('couldnt find endpoint');
        // }

        //Association de l'utilisateur courant au endpoint
        //$this->notificationService->registerUser($this->userService->getLoggedUser(), $endpoint);
    }
}
