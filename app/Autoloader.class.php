<?php
namespace app;
// class Autoloader{
//     public function __construct($namespace,$dir  )
//     {
//         // Make sure it ends with a '\'.
//         $namespace       = rtrim( $namespace, '\\' ) . '\\';
//         $this->namespace = $namespace;
//         $this->length    = strlen( $namespace );
//         $this->dir       = rtrim( $dir , '/' ) . '/';
//     }

//     /**
//     * @param string $search
//     * @return void
//     */
//     public function load( $search )
//     {
        
//         if ( strncmp( $this->namespace, $search, $this->length ) !== 0 ) {
//             return;
//         }
//         $name = substr( $search, $this->length );
//         $path = $this->dir . str_replace( '\\', '/', $name ) . '.class.php';
//         if ( is_readable( $path ) && !class_exists($name,true) ) {
//             require_once $path;
//         }
//     }
// }
// spl_autoload_register( [ new Autoloader('app',APPPATH), 'load' ] );
// spl_autoload_register( [ new Autoloader('src',SRCPATH), 'load' ] );
function __autoload ( $class ) {
	if ( class_exists( $class, true ) )
		return true;
    $class = ltrim( $class, '\\' );
	$file  = '';
	if ( $separator = strripos( $class, '\\' ) ) {
        $namespace = substr( $class, 0, $separator );
        var_dump($namespace);
		if ( $namespace != __NAMESPACE__ )
			$file  .= str_replace( '\\', '/', $namespace ) . '/';
		$class = substr( $class, $separator + 1 );
    }
    $file .= str_replace( '_', '/', $class ) . '.class.php';
	if ( ! @include_once( ROOT.'/'.$file ) )
		return false;
	return true;
}
spl_autoload_register( __NAMESPACE__ . '\__autoload' );