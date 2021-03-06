<?php
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 24.5.2016
 * Time: 18:20
 */

namespace phptojs;


/**
 * @codeCoverageIgnore
 */
class Autoloader {
	/** @var bool Whether the autoloader has been registered. */
	private static $registered = false;

	/**
	 * Registers PhpParser\Autoloader as an SPL autoloader.
	 *
	 * @param bool $prepend Whether to prepend the autoloader instead of appending
	 */
	static public function register($prepend = false) {
		if (self::$registered === true) {
			return;
		}
		spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
		self::$registered = true;
	}

	/**
	 * Handles autoloading of classes.
	 *
	 * @param string $class A class name.
	 */
	static public function autoload($class) {
		if (0 === strpos($class, 'phptojs\\')) {
			$fileName = __DIR__ . strtr(substr($class, 7), '\\', '/') . '.php';
			if (file_exists($fileName)) {
				require $fileName;
			}
		}elseif (0 === strpos($class, 'jsphp\\')) {
			$fileName = __DIR__ ."/lib/php" . strtr(substr($class, 5), '\\', '/') . '.php';
			if (file_exists($fileName)) {
				require $fileName;
			}
		}
	}
}