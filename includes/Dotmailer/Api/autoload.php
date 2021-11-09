<?php
/**
 * Autoloader główny.
 */
spl_autoload_register(function($className) {

	if (0 !== strpos($className, 'DotMailer\\Api\\')) {
		return false;
	}

    $path = str_replace('DotMailer\\Api\\', '', $className);
	$path = ('\\' === DIRECTORY_SEPARATOR) ? $path : str_replace('\\', DIRECTORY_SEPARATOR, $path);

	$path = realpath(__DIR__ . DIRECTORY_SEPARATOR . "{$path}.php");

	if ($path) {
		include $path;
	}
});
