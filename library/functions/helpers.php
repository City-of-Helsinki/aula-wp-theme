<?php

use LuuptekWP\Utils;

/**
 * Helper-functions
 *
 * @package Oppijaportaali
 */

/**
 * Used to get the asset uri
 *
 * @param string $filename File name
 *
 * @return string
 */
function asset_uri( $filename ) {
	return trailingslashit( get_template_directory_uri() ) . "assets/dist/{$filename}";
}

function asset_local( $filename ) {
	return trailingslashit( get_template_directory() ) . "assets/dist/{$filename}";
}

/**
 * Include all files from folder
 *
 * @param string $dir Directory
 * @param string $suffix Suffix of the file
 */
function require_files( $dir, $suffix = 'php' ) {
	$dir = trailingslashit( $dir );

	if ( ! is_dir( $dir ) ) {
		return;
	}

	$files = new DirectoryIterator( $dir );

	foreach ( $files as $file ) {
		if ( ! $file->isDot() && $file->getExtension() === $suffix ) {
			$filename = $dir . $file->getFilename();
			require_once( $filename );
		}
	}
}

/**
 * Utils-class as function-wrapper
 */
if ( ! function_exists( 'UTILS' ) ) :

	/**
	 * UTILS() function to create Utils class in classes/Utils.php
	 */
	function UTILS() {
		return new Utils();
	}
endif;
