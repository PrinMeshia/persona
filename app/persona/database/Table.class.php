<?php 
namespace app\persona\database;
use database;
use QueryBuilder;

/**
 * 
 */
class Table 
{
	protected $table;
	protected $db;
	protected $query;
	public function __construct(Database $db){
		$this->db = $db;
		$this->query = new QueryBuilder();
		if(is_null($this->table)){
			$parts = explode('\\',get_class($this));
			$className = end($parts);
			$this->table = strtolower(str_replace('Table','',$className));
		}
	}
	
	public function query($statement, $attr = NULL, $single = FALSE){
		if($attr){
			return $this->db->prepare($statement,$attr,str_replace('Table','Entity',get_class($this)),$single);
		}else{
			return $this->db->query($statement,str_replace('Table','Entity',get_class($this)),$single);
		}
	}
	
	public function getAll(){
		return $this->query('SELECT * FROM '.$this->table);
	}
	public function find($key,$elem){
		return $this->query('SELECT * FROM '. $this->table .' WHERE '.$key.' = ?', [$elem],true);
	}
	public function findLike($key,$elem){
		return $this->query('SELECT * FROM '.$this->table .'	WHERE '.$key.' like ?',	['%'.$elem.'%']);
	}
}
