<?php
namespace src\model;
use app\persona\database\Model;

class Test extends Model {
	public function data($name) {
		return ['name' => $name, 'age' => rand(1,50)];
	}
}