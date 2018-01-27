<?php
namespace app\persona\cache;
class Cache extends Item {
	protected $_id;
	static protected $_cache = array();
	public function offsetSet ( $name, $value ) {
		$this->id( false );
		parent::offsetSet( $name, $value );
	}
	public function append ( $value ) {
		$this->id( false );
		return parent::append( $value );
	}
	public function exchangeArray ( $array ) {
		$this->id( false );
		return parent::exchangeArray( $array );
	}
	public function __toString () {
		return $this->cacheExist( $this->id() ) ? (NULL): $this->getCache();
	}
	protected function id ( $id = null ) {
		if ( $id === false )
			return $this->_id = null;
		if ( $id )
			return $id;
		return $this->_id ?: ( $this->_id = md5( serialize( $this ) ) );
	}
	public function indent ( $indent = 1, $indentation = "  " ) {
		$this->id( false );
		return parent::indent( $indent, $indentation );
	}
	public function getCache ( $id = null ) {
		return self::$_cache[ $this->id( $id ) ] = $this->render();
	}
	public function cacheExist ( $id = null ) {
		if ( is_null( $id ) )
			return isset( self::$_cache[ $id = $this->id() ] ) ? $id : false;
		return isset( self::$_cache[ $id ] ) ? self::$_cache[ $id ] : false;
	}
}