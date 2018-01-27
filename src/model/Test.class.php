<?php
namespace src\model;
class Test extends \app\persona\database\Model {
	public function data($name) {
		return ['name' => $name, 'age' => rand(1,50)];
	}
}