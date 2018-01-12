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
$boot = app\persona\Persona::singleton();

if($boot->config->currentEnv != '' && isset($boot->config->environnement[$boot->config->currentEnv]['debug'])){
    switch ($boot->config->environnement[$boot->config->currentEnv]['debug'])
    {
        case 'full':
            error_reporting(-1);
            ini_set('display_errors', 1);
            $boot->profiler = 'app\\module\\profiler\\Profiler';
            break;
        case 'partial':
        case 'none':
            ini_set('display_errors', 0);
            if (version_compare(PHP_VERSION, '5.3', '>='))
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
            else
                error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
            break;
        default:
            $boot->response->error('The application environment is not set correctly',503);
            exit(1); // EXIT_ERROR
    }
    if (ini_get('date.timezone') == '' && function_exists('date_default_timezone_set'))
    {
        if (function_exists('date_default_timezone_get'))
            date_default_timezone_set(@date_default_timezone_get());
        else
            date_default_timezone_set('UTC');
    }
    $boot->createRoute('/persona/','RESPOND', function() use ( $boot ){
        $boot->controller->call('test');
    });
    $boot->createRoute('/persona/contact','GET', function() use ( $boot ){
        $boot->controller->call('test','contact');
    });
    $boot->createRoute('/persona/name/:name','GET', function($name) use ( $boot ){
        $boot->controller->call('test','name',[$name]);
    });
    $boot->createRoute('','RESPOND', function() use ( $boot ){
        return $boot->response->ResponseHTML('<p> This is a response with code 404. </p>', 404);
    });

    $boot->listen();
    if($boot->config->environnement[$boot->config->currentEnv]['debug'] == 'full')
        echo $boot->profiler->display();
}else{
     $boot->response->error('The application environment is not set correctly',503);
    exit(1); // EXIT_ERROR
}

