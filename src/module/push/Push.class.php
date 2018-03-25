<?php
/**
 * 
 */
namespace src\module\push;
use app\persona\controller\AbstractController;
class Push extends AbstractController
{

    public function subscribeAction(){
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
    public function unsubscribeAction(){

    }
    public function sendAction(){
        
    }
}
