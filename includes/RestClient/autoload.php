<?php
/**
 * Autoloader główny.
 */
spl_autoload_register(function($className) {

	if (0 !== strpos($className, 'RestClient\\')) {
		return false;
	}

    $path = str_replace('RestClient\\', '', $className);
    $path = ('\\' === DIRECTORY_SEPARATOR) ? $path : str_replace('\\', DIRECTORY_SEPARATOR, $path);

	$path = realpath(__DIR__ . DIRECTORY_SEPARATOR . "{$path}.php");

	if ($path) {
		include $path;
	}
});
