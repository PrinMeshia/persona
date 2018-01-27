<?php
namespace app\persona\config;
 use \app\persona\helpers\Helpers;
class Environment {
    private $personna;
    public function __construct($persona){
        $this->personna = $persona;
        $this->setEnvironment();
    }
    private  function setEnvironment(){
        if($this->personna->config->envUrl){
            foreach ($this->personna->config->envUrl as $key => $value) {
                foreach ($value as $arrayAddress) {
                    if(array_search(Helpers::getUrlServer(),$arrayAddress) !== false){
                        $path = $this->personna->config->path->environment.$key.".json";
                        if(file_exists(ROOT.$path)){
                            $this->personna->config->load($path); 
                            
                            $this->personna->config->system->currentEnv = $key;
                        }
                    }
                }
            }
        }else{
            $this->personna->response->error('The application environment is not set correctly',503);
            exit(1);
        }
    }
}