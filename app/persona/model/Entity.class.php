<?php 
namespace app\persona\model;
class Entity
{
	public function __get($key){
		$method = 'get'.ucfirst($key);
		$this->$key = $this->$method();
		return $this->$key;
	}
}