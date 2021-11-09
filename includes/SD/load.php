<?php
include_once __DIR__.'/Options/load.php';
include_once __DIR__.'/Walkers/NavPrimary.php';
include_once __DIR__.'/Walkers/B4NavWalker.php';
include_once __DIR__.'/Template/load.php';
include_once __DIR__.'/Contact/load.php';
include_once __DIR__.'/Admin/load.php';

/**
 * Autoloader główny. Ładuje klasy w przestrzeni SD z folderu /lib.
 */
spl_autoload_register( function($className) {
	if ( 0 !== strpos($className, 'SD') ) {
		return false;
	}
	$path = str_replace( 'SD\\', '\\', $className );

	if ( '\\' !== DIRECTORY_SEPARATOR ) {
		$path = str_replace( '\\', DIRECTORY_SEPARATOR, $path );
	}

	$path = realpath( __DIR__ . DIRECTORY_SEPARATOR . "{$path}.php" );

	if ( file_exists($path) ) {
		include $path;
	}
} );
