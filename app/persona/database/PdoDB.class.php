<?php
namespace app\persona\database;
use \PDO;
class PdoDB extends Database{
   
    public function newConnection()
    {
        $dsn = 'mysql:host=' . $config->host . ';dbname=' . $config->dbname;
                try{
                    $pdo = new PDO($config->dsn, $config->login, $config->password);
                    $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pdo ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                    $this->connections[] = $pdo;
                    $connection_id = count( $this->connections )-1;
                }
                catch(PDOException $e){
                     trigger_error('Error connecting to host. '.$e->getMessage(), E_USER_ERROR);
                }  
        return $connection_id;
    }
    public function closeConnection()
    {
        $this->connections[$this->activeConnection] = null;
        unset($this->connections[$this->activeConnection]);
    }
    public function setActiveConnection( int $new )
    {
        $this->activeConnection = $new;
    }
    public function cacheQuery( $queryStr )
    {
        $stmt = $this->connections[$this->activeConnection]->prepare( $queryStr );
        $result = $stmt->execute();    

        if( !$result )
        {
            trigger_error('Error executing and caching query: '.$this->connections[$this->activeConnection]->errorInfo()[0], E_USER_ERROR);
            return -1;
        }
        else
        {
            $this->queryCache[] = $stmt;
            return count($this->queryCache)-1;
        }
    }
    public function numRowsFromCache( $cache_id )
    {
        return $this->queryCache[$cache_id]->rowCount();    
    }
    public function resultsFromCache( $cache_id )
    {
        return $this->queryCache[$cache_id]->fetch(PDO::FETCH_ASSOC);
    }
    public function cacheData( $data )
    {
        $this->dataCache[] = $data;
        return count( $this->dataCache )-1;
    }
    public function dataFromCache( $cache_id )
    {
        return $this->dataCache[$cache_id];
    }
    public function deleteRecords( $table, $condition, $limit )
    {
        $limit = ( $limit == '' ) ? '' : ' LIMIT ' . $limit;
        $delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
        $this->executeQuery( $delete );
    }
    public function updateRecords( $table, $changes, $condition )
    {
        $update = "UPDATE " . $table . " SET ";
        foreach( $changes as $field => $value )
        {
            $update .= "`" . $field . "`='{$value}',";
        }
        $update = substr($update, 0, -1);
        if( $condition != '' )
        {
            $update .= "WHERE " . $condition;
        }
        $this->executeQuery( $update );
         
        return true;
         
    }
    public function insertRecords( $table, $data )
    {
        $fields  = "";
        $values = "";
        foreach ($data as $f => $v)
        {
             
            $fields  .= "`$f`,";
            $values .= ( is_numeric( $v ) && ( intval( $v ) == $v ) ) ? $v."," : "'$v',";
         
        }
        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);
         
        $insert = "INSERT INTO $table ({$fields}) VALUES({$values})";
        $this->executeQuery( $insert );
        return true;
    }
    public function executeQuery( $queryStr )
    {
        if( !$result = $this->connections[$this->activeConnection]->prepare( $queryStr )->execute() )
        {
            trigger_error('Error executing query: '.$this->connections[$this->activeConnection]->errorInfo(), E_USER_ERROR);
        }
        else
        {
            $this->last = $result;
        }
         
    }
    public function getRows()
    {
        return $this->last->fetch(PDO::FETCH_ASSOC);
    }
    public function affectedRows()
    {
        return $this->$this->connections[$this->activeConnection]->affected_rows;
    }
    public function sanitizeData( $data )
    {
        return $this->connections[$this->activeConnection]->real_escape_string( $data );
    }
    public function __deconstruct()
    {
        foreach( $this->connections as $connection )
        {
            $connection = null;
            unset($connection);
        }
    }
}
?>