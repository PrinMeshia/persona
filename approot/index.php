<?php
/**
 * Created by Prim'Meshia.
 * Datetime : 03/04/2017 11:36
 * Project : persona
 * file : index.php
 * description :
 */

$startTime = microtime(true);
ob_start();
define('PUBLIC_PATH',dirname(realpath(__FILE__)) . "/");
define('ROOT',dirname(PUBLIC_PATH). "/");
define('ROOTPATH',dirname(PUBLIC_PATH));
require_once  '../app/Autoloader.class.php';
\app\persona\Persona::getInstance()->run();


