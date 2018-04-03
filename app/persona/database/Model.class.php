<?php 
namespace app\persona\database;

use app\persona\Persona;
/**
 * 
 */
class Model 
{
	protected $table;
	protected $db;
	protected $query;
	protected $cache;
	public function __construct(){
		$this->db = Persona::getInstance()->pdo;
		$this->query = new \app\persona\database\QueryBuilder();
		if(is_null($this->table)){
			 $parts = explode('\\',get_class($this));
			 $className = end($parts);
			$this->table = $className;
		}
	}
	
	public function query($statement, $attr = NULL, $single = FALSE){
		if($attr){
			return $this->db->prepare($statement,$attr,$single);
		}else{
			return $this->db->query($statement,$single);
		}
	}
	
	public function getAll(){
		return $this->query('SELECT * FROM '.$this->table);
	}
	public function find($key,$elem){
		return $this->query('SELECT * FROM '. $this->table .' WHERE '.$key.' = ?', [$elem],true);
	}
	public function findLike($key,$elem){
		return $this->query('SELECT * FROM '.$this->table .' WHERE '.$key.' like ?',	['%'.$elem.'%']);
	}
	public function exists($id){
        $database = Database::openConnection();
        $database->getById($this->table, $id);
        return $database->countRows() === 1;
    }

}
