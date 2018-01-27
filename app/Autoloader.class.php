<?php
class Autoloader{
    public function __construct($namespace,$dir  )
    {
        // Make sure it ends with a '\'.
        $namespace       = rtrim( $namespace, '\\' ) . '\\';
        $this->namespace = $namespace;
        $this->length    = strlen( $namespace );
        $this->dir       = rtrim( $dir , '/' ) . '/';
    }

    /**
    * @param string $search
    * @return void
    */
    public function load( $search )
    {
        if ( strncmp( $this->namespace, $search, $this->length ) !== 0 ) {
            return;
        }
        $name = substr( $search, $this->length );
        $path = $this->dir . str_replace( '\\', '/', $name ) . '.class.php';
        if ( is_readable( $path ) && !class_exists($name) ) {
            require_once $path;
        }
    }
}
spl_autoload_register( [ new Autoloader('app',APPPATH), 'load' ] );
spl_autoload_register( [ new Autoloader('src',SRCPATH), 'load' ] );
