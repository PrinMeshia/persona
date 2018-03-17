<?php
namespace app\persona\debug;

use app\persona\Persona;

class Debug {
    function __construct()
    {
        if(Persona::getInstance()->config->debug){
            switch (Persona::getInstance()->config->debug)
            {
                case 2:
                    error_reporting(-1);
                    ini_set('display_errors', 1);
                    Persona::getInstance()->profiler = 'app\\vendor\\profiler\\Profiler';
                    break;
                case 1:
                case 0:
                    ini_set('display_errors', 0);
                    if (version_compare(PHP_VERSION, '5.3', '>='))
                        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                    else
                        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
                    break;
                default:
                Persona::getInstance()->response->error('The application environment is not set correctly',503);
                    exit(1); 
            }
        }else{
            Persona::getInstance()->response->error('The application environment is not set correctly',503);
            exit(1); 
        }
    }
}