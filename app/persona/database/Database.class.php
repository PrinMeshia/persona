<?php 
namespace app\persona\database;
/**
 * 
 */
class Database
{

    private $connections = [];
    private $activeConnection = 0;
    private $queryCache = [];
    private $dataCache = [];
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
