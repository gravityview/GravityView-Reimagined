<?php
namespace GV;

use GFAPI;

class Search {

	function __construct() {

		spl_autoload_register( array( $this, 'autoloader' ) );

		$this->include_files();

	}

	/**
	 * Load all the files in the /search/ folder
	 *
	 * @uses Search::autoloader When loading the files, they may load out of order; load the other files if needed
	 */
	function include_files() {
		foreach ( glob( plugin_dir_path( __FILE__ ) . 'class-gv-search-*.php' ) as $filename ) {
			require_once( $filename );
		}
	}

	function autoloader( $class_name = '' ) {

		if ( false !== strpos( $class_name, 'GV\Search' ) ) {

			$file_name = $class_name;
			$file_name = str_replace( 'GV\\', '', $file_name );
			$file_name = str_replace( '_', '-', $file_name );
			$file_name = sprintf( 'class-gv-%s.php', strtolower( $file_name ) );

			include plugin_dir_path( __FILE__ ) . $file_name;
		}
	}
	
}