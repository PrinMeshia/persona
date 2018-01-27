<?php
namespace app\persona\debug;
class Debug {
    function __construct($personna)
    {
        if($personna->config->debug){
            switch ($personna->config->debug)
            {
                case 2:
                    error_reporting(-1);
                    ini_set('display_errors', 1);
                    $personna->profiler = $personna->config->namespace->vendor.'profiler\\Profiler';
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
                    $personna->response->error('The application environment is not set correctly',503);
                    exit(1); // EXIT_ERROR
            }
        }else{
            $personna->response->error('The application environment is not set correctly',503);
            exit(1); // EXIT_ERROR
        }
    }
}