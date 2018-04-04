<?php
/**
 * 
 */
namespace src\module\push;
use \Exception;
use app\persona\controller\AbstractController;

class Command extends AbstractController
{
    public function indexAction(){
        
    }
    public function subscribeAction(){
        $content = $this->request->getBody();
        $data = json_decode($content);
        if (isset($data->endpoint)){
            $endpoint = $data->endpoint;
            $result = $this->Notification->insertData($endpoint);
            $this->reponse->JsonResponse($result);
        }else{
            throw new Exception('couldnt find endpoint');
        }

        //Association de l'utilisateur courant au endpoint
        //$this->notificationService->registerUser($this->userService->getLoggedUser(), $endpoint);
    }
    public function unsubscribeAction(){

    }
    public function pushRegisterAction(){
        
    }
}
