<?php
namespace app\persona\config;
 use \app\persona\helpers\Helpers;
class Environment {
    private $persona;
    public function __construct($persona){
        $this->persona = $persona;
        
    }
    
    public function setEnvironment($filename){
   
        if (file_exists(ROOT.$filename)) {
            $content = file_get_contents(ROOT.$filename);
            $content = json_decode($content, true);
            foreach ($content as $key => $value) {
                foreach ($value as $arrayAddress) {
                    
                    if(array_search(Helpers::getUrlServer(),$arrayAddress) !== false || array_search(Helpers::getAddressServer(),$arrayAddress) !== false){
                        $this->persona->setCurrentEnv($key);
                    }
                }
            }
        }else{
            $this->persona->response->error('The application environment is not set correctly',503);
            exit(1);
        }
    }
}