<?php 
namespace app\persona\database;
/**
 * 
 */
class Database
{

    private $connections = array();
    private $activeConnection = 0;
    private $queryCache = array();
    private $dataCache = array();
    private $last;
    private $personna;


    /**
     * @param $dbName
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbHost
     */
    public function __construct($personna){
        $personna = $personna;
    }

}
