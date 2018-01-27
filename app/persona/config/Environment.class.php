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
                if(array_search(Helpers::getUrlServer(),$value) !== false){
                    if($this->personna->config->environment->{$key}){
                        $this->personna->config->system->currentEnv = $key;
                    }
                }
            }
        }
    }
}