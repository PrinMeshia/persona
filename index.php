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
define('APPPATH',PUBLIC_PATH . "/app/");

define('CONFPATH',APPPATH . "config/");
define('SRCPATH',APPPATH . "src/");
define('MODULEPATH', SRCPATH .'modules/');


define('ENVDEV','dev');
define('ENVPREV','staging');
define('ENVPROD','prod');
define('DEFENV', ENVDEV);

require_once APPPATH . 'Autoloader.class.php';
$boot = app\persona\Bootstrap::singleton();

if ((php_sapi_name() == 'cli') or defined('STDIN'))
{
    $env = DEFENV;
    if (isset($argv))
    {
        $key = (array_search('--env', $argv));
        $environment = $argv[$key +1];
        unset($argv[$key], $argv[$key +1]);
    }
    define('ENV', $env);
}
if (!defined('ENV')) define('ENV', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : DEFENV);
switch (ENV)
{
    case ENVDEV:
        error_reporting(-1);
        ini_set('display_errors', 1);
        $boot->profiler = 'app\\module\\profiler\\Profiler';
        break;
    case ENVPREV:
    case ENVPROD:
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        else
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}
if (ini_get('date.timezone') == '' && function_exists('date_default_timezone_set'))
{
    if (function_exists('date_default_timezone_get'))
        date_default_timezone_set(@date_default_timezone_get());
    else
        date_default_timezone_set('UTC');
}

$boot->createRoute('/persona/','GET', function() use ( $boot ){
    $boot->controller->call('Test');
});
$boot->createRoute('/persona/contact','GET', function() use ( $boot ){
    $boot->controller->call('Test','contact');
});
$boot->createRoute('/persona/name/:name','GET', function($name) use ( $boot ){
    $boot->controller->call('Test','name',[$name]);
});
$boot->createRoute('','RESPOND', function() use ( $boot ){
    return $boot->response->ResponseHTML('<p> This is a response with code 404. </p>', 404);
});

$boot->listen();
if(ENV == ENVDEV)
    echo $boot->profiler->display();
