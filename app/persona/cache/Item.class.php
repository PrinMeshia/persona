<?php
namespace app\persona\cache;
class Item extends Data {
	protected $_indent;
	public function __construct () {}
	static public function init () {
		return new self();
	}
	public function getArrayCopy () {
		static $filter;
		if ( ! $filter )
			$filter = function ( $value ) {
				return $value instanceof Item ? (string) $value : $value;
			};
		return array_map( $filter, parent::getArrayCopy() );
	}
	public function __toString () {
		return $this->render();
	}
	static protected function _safe ( $value, $mode ) {
		if ( ! is_array( $value ) && ! $value instanceof Traversable )
			return htmlentities( $value, ENT_COMPAT, 'UTF-8' );
		foreach ( $value as $index => $item )
			$value[ $index ] = self::_safe( $item, $mode );
		return $value;
	}
	public function set ( $name, $value = false, $safe = false ) {
		if ( ! is_array( $name ) && ! $name instanceof Traversable )
			$this->offsetSet( (string) $name, $safe ? self::_safe( $value, $safe ) : $value );
		else
			foreach ( $name as $_name => $_value )
				$this->set( $_name, $_value, $value );
		return $this;
	}
	public function indent ( $indent = 1, $indentation = "  " ) {
		$this->_indent = implode( '', array_fill( 0, $indent, $indentation ) );
		return $this;
	}
	protected function _indent ( $buffer ) {
		return preg_replace( '/(^|\r?\n|\r)(?!\s*$)/', '$1' . $this->_indent, $buffer );
	}
	protected function render () {
		return $this->_indent( implode( PHP_EOL , $this->getArrayCopy() ) );
	}
}