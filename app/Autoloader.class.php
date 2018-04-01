<?php
namespace app;

class Autoloader
{
	public function __construct()
	{
	}

	/**
	 * @param $class
	 * @return bool
	 */
	public function __autoload($class)
	{
		if (class_exists($class, true))
			return true;
		$class = ltrim($class, '\\');
		$file = '';
		if ($separator = strripos($class, '\\')) {
			$namespace = substr($class, 0, $separator);
			if ($namespace != __NAMESPACE__)
				$file .= str_replace('\\', '/', $namespace) . '/';
			$class = substr($class, $separator + 1);
		}
		$file .= str_replace('_', '/', $class) . '.class.php';
		if (!@include_once(ROOT . '/' . $file))
			return false;
		return true;
	}
}
spl_autoload_register([new Autoloader(), '__autoload']);