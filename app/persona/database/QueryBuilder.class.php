<?php 
namespace app\persona\database;
class QueryBuilder
{
	private $fields = [];
	private $condition = [];
	private $from = [];
	private $joins = [];
	private $group = [];

	/**
	 * @param $method
	 * @param $arguments
	 * @return mixed
     */
	public static function __callStatics($method, $arguments){
		$query = new QueryBuilder();
		return call_user_func_array([$query,$method],$arguments);
	}

	/**
     * Initialisation de la requ�te
	 * @return string
     */
	public function init(){

		$this->fields = [];
		$this->from = [];
		$this->joins = [];
		$this->condition = [];
		$this->group = [];
        $this->order = [];
		return $this;
	}
	public function __toString(){
		$query = 'SELECT '. implode(', ',$this->fields)
		.' FROM '. implode(', ',$this->from);
		if(count($this->joins) > 0 )
			$query .=' '.implode(' ',$this->joins);
		if(count($this->condition) > 0 )
			$query .=' WHERE '. implode(' AND ',$this->condition);
		if(count($this->group) > 0 )
		$query .=' GROUP BY '.implode(', ',$this->group);
        if(count($this->order) > 0 )
            $query .=' ORDER BY '.implode(', ',$this->order);

		return $query;
	}

	/**
	 * @return $this
     */
	public function select(){
		$this->fields = func_get_args();
		return $this;
	}

	/**
	 * @return $this
     */
	public function where(){
		foreach(func_get_args() as $arg){
			$this->condition[] = $arg;
		}
		return $this;
	}

	/**
	 * @param $table
	 * @param null $alias
	 * @return $this
     */
	public function from($table, $alias = null)
	{
		if (is_null($alias)) {
			$this->from[] = "$table";
		} else {
			$this->from[] = "$table AS $alias";
		}
		return $this;
	}

	/**
	 * @param $table1
	 * @param $table2
	 * @param $table1key
	 * @param $table2key
	 * @return $this
     */
	public function leftjoin($table1, $table2, $table1key,$table2key ){
	$this->join('LEFT', "$table1 ON $table1.$table1key = $table2.$table2key");
		return $this;
	}

	/**
	 * @param $table1
	 * @param $table2
	 * @param $table1key
	 * @param $table2key
	 * @return $this
     */
	public function rightjoin($table1, $table2, $table1key,$table2key ){
		$this->join('RIGHT', "$table1 ON $table1.$table1key = $table2.$table2key");
		return $this;
	}

	/**
	 * @param $table1
	 * @param $table2
	 * @param $table1key
	 * @param $table2key
	 * @return $this
     */
	public function innerjoin($table1, $table2, $table1key,$table2key ){
		$this->join('INNER', "$table1 ON $table1.$table1key = $table2.$table2key");
		return $this;
	}

	/**
	 * @param $table1
	 * @param $table2
	 * @param $table1key
	 * @param $table2key
	 * @return $this
     */
	public function outerjoin($table1, $table2, $table1key,$table2key ){
		$this->join('OUTER', "$table1 ON $table1.$table1key = $table2.$table2key");
		return $this;
	}
	/**
	 * @param $type
	 * @param $join
     */
	private function join($type, $join){
		$this->joins[] = "$type JOIN $join";
	}

	public function group(){
		$this->group = func_get_args();
		return $this;
	}
    public function order(){
        $this->order = func_get_args();
        return $this;
    }

}

?>