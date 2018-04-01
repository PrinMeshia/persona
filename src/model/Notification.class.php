<?php
namespace src\model;
use app\persona\database\Model;

class Notification extends Model {
    public function getData(){
        $sql = $this->query->init()->select('endpoint','push')
            ->from($this->table);
        return $this->query($sql);
    }
	public function insertData($endpoint){
        return $this->insert("insert into notification(endpoint,push) value('$endpoint',1)");
    }
}