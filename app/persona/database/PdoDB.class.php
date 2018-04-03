<?php
namespace app\persona\database;
use \PDO;
use app\persona\Persona;
class PdoDB extends Database
{
    private $connection;

    /**
     * @return PDO
     */
    private function getConnexion()
    {
        if ($this->pdo === null) {
            $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            try {
                $pdo = new PDO($dsn, $this->dbUser, $this->dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $this->connection = $pdo;
            } catch (PDOException $e) {
                throw new \Exception('Error connecting to host. ' . $e->getMessage(), E_USER_ERROR);
            }
        }
        return $this->connection;
    }
    public function cacheQuery($statement)
    {
        $stmt = $this->getConnexion()->prepare($statement);
        $result = $stmt->execute();

        if (!$result) {
            throw new \Exception('Error executing and caching query: ' . $this->getConnexion()->errorInfo()[0], E_USER_ERROR);
            return -1;
        } else {
            $this->_queryCache[] = $stmt;
            return count($this->_queryCache) - 1;
        }
    }

    /**
     * @param $statement
     * @param bool|false $single
     * @return array|mixed
     */
    public function query($statement, $single = false)
    {
        $history = ['sql' => $statement];
        if (!$req = $this->getConnexion()->query($statement)) {
            throw new \Exception('Error executing query: ' . $this->connections[$this->activeConnection]->errorInfo(), E_USER_ERROR);
        } else {
            $req->setFetchMode(PDO::FETCH_OBJ);
            if ($single) {
                $datas = $req->fetch();
            } else {
                $datas = $req->fetchAll();
            }
            return $datas;
        }
    }


    /**
     * @param $statement
     * @param $attr
     * @param bool|false $single
     * @return array|mixed
     */
    public function prepare($statement, $attr, $single = false)
    {
        $req = $this->getConnexion()->prepare($statement);
        $req->execute($attr);
        $req->setFetchMode(PDO::FETCH_CLASS);
        if ($single) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }

    public function sanitizeData($data)
    {
        return $this->getConnexion()->real_escape_string($data);
    }
    public function numRowsFromCache($cacheid)
    {
        return $this->queryCache[$cacheid]->rowCount();
    }
    public function resultsFromCache($cacheid)
    {
        return $this->queryCache[$cacheid]->fetch(PDO::FETCH_ASSOC);
    }
    public function cacheData($data)
    {
        $this->_dataCache[] = $data;
        return count($this->_dataCache) - 1;
    }
    public function dataFromCache($cache_id)
    {
        return $this->_dataCache[$cache_id];
    }
    public function affectedRows()
    {
        return $this->getConnexion()->affected_rows;
    }
}