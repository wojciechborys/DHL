<?php

/**
 * Autoloader główny
 * Ładuje klasy w przestrzeni SD z folderu /includes
 */
spl_autoload_register( function($className) {

	if ( 0 !== strpos($className, 'SD') ) {
		return false;
	}

	$path = $className;

	if ( '\\' !== DIRECTORY_SEPARATOR ) {
		$path = str_replace( '\\', DIRECTORY_SEPARATOR, $path );
	}

	$path = realpath( __DIR__ . DIRECTORY_SEPARATOR . "{$path}.php" );

	if ( file_exists($path) ) {

		include $path;
	}
} );
