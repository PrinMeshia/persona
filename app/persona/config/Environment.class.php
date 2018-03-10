<?php
namespace app\persona\config;
 use \app\persona\helpers\Helpers;
 use app\persona\Persona;
class Environment {
    public function __construct(){}
    
    public function setEnvironment($filename){
   
        if (file_exists(ROOT.$filename)) {
            $content = file_get_contents(ROOT.$filename);
            $content = json_decode($content, true);
            foreach ($content as $key => $value) {
                foreach ($value as $arrayAddress) {
                    
                    if(array_search(Helpers::getUrlServer(),$arrayAddress) !== false || array_search(Helpers::getAddressServer(),$arrayAddress) !== false){
                        Persona::getInstance()->setCurrentEnv($key);
                    }
                }
            }
        }else{
            Persona::getInstance()->response->error('The application environment is not set correctly',503);
            exit(1);
        }
    }
}