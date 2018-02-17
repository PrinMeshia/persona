<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 11:36
 * Project : persona
 * file : index.php
 * description :
 */
$startTime = microtime(true);
define('PUBLIC_PATH',dirname(realpath(__FILE__)) . "/");
define('ROOT',dirname(PUBLIC_PATH));
require_once ROOT . '/app/Autoloader.class.php';
$persona = app\persona\Persona::singleton();
$persona->listen();
