<?php
namespace app\persona\cache;
class Data extends \ArrayObject {
	static public $filter;
	static public function filter ( $data ) {
		return is_callable( self::$filter ) ? call_user_func( self::$filter, $data ) : $data;
	}
	public function getArrayCopy () {
		return array_map( array( $this, 'filter' ), parent::getArrayCopy() );
	}
	public function exchangeArray ( $array ) {
		parent::exchangeArray( $array );
		return $this;
	}
	public function append ( $value ) {
		parent::append( $value );
		return $this;
	}
	public function prepend ( $value ) {
		return $this->exchangeArray( array_merge( array( $value ), (array) $this ) );
	}
	public function offsetGet ( $name ) {
		if ( $this->offsetExists( $name ) )
			return self::filter( parent::offsetGet( $name ) );
	}
	public function __set ( $name, $value ) {
		return $this->offsetSet( $name, $value );
	}
	public function __get ( $name ) {
		return $this->offsetGet( $name );
	}
	public function __unset ( $name ) {
		$this->offsetUnset( $name );
	}
	public function __isset ( $name ) {
		return $this->offsetExists( $name );
	}
	public function grep ( $pattern ) {
		return preg_grep( $pattern , (array) $this );
	}
}