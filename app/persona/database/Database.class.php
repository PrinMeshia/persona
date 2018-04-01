<?php 
namespace app\persona\database;

use app\persona\Persona;

/**
 * 
 */
class Database
{
    private $_cacheEnable = false;
    private $_cacheTime = "";
    private $_cacheDir = false;
    private $_queryCache = [];
    private $_dataCache = [];

    /**
     * @param $dbName
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbHost
     */
    public function __construct()
    {
        if (Persona::getInstance()->config->database) {
            $this->dbName =Persona::getInstance()->config->database->name;
            $this->dbHost =Persona::getInstance()->config->database->host;
            $this->dbUser =Persona::getInstance()->config->database->user;
            $this->dbPass =Persona::getInstance()->config->database->pass;
            $this->_cacheEnable =Persona::getInstance()->config->database->cache;
            $this->_cacheTime =Persona::getInstance()->config->database->cache_time;
            $this->_cacheDir =Persona::getInstance()->config->path->cache;    
        }
    }

}
