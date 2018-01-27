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
require_once APPPATH . 'Autoloader.class.php';
$persona = app\persona\Persona::singleton();
    if (ini_get('date.timezone') == '' && function_exists('date_default_timezone_set'))
    {
        if (function_exists('date_default_timezone_get'))
            date_default_timezone_set(@date_default_timezone_get());
        else
            date_default_timezone_set('UTC');
    }
    $persona->listen();

