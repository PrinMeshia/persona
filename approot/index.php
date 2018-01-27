<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 11:36
 * Project : a10t2
 * file : index.php
 * description :
 */
$startTime = microtime(true);
define('PUBLIC_PATH',dirname(realpath(__FILE__)) . "/");
define('ROOT',dirname(PUBLIC_PATH));
define('APPPATH',ROOT . "/app/");
define('CONFPATH',APPPATH . "config/");
define('SRCPATH',ROOT . "/src/");
define('MODPATH', SRCPATH .'modules/');
require_once APPPATH . 'Autoloader.class.php';
$persona = app\persona\Persona::singleton();
if($persona->config->system->currentEnv != '' && isset($persona->config->environment->{$persona->config->system->currentEnv}->debug)){ 
    if (ini_get('date.timezone') == '' && function_exists('date_default_timezone_set'))
    {
        if (function_exists('date_default_timezone_get'))
            date_default_timezone_set(@date_default_timezone_get());
        else
            date_default_timezone_set('UTC');
    }
    $persona->listen();

}else{
    $persona->response->error('The application environment is not set correctly',503);
    exit(1); // EXIT_ERROR
}

