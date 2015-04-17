<?php

/**
 * Hold all the Views
 */
class GV_View_Collection {

	/**
	 * @var GV_View[]
	 */
	var $views = array();

	private static $instance;

	private function __construct() {}

	/**
	 * @return GV_View_Collection
	 */
	public static function get_instance() {

		if( empty( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * @param $id
	 *
	 * @return GV_View
	 */
	function get( $id ) {
		return isset( $this->views[ $id ] ) ? $this->views[ $id ] : NULL;
	}

	/**
	 * @param int $id
	 *
	 * @return boolean False: Already existed, True: added
	 */
	function add( $View ) {

		// Make sure the $View is a GV_View
		if( ! $View instanceof GV_View ) {
			$View = new GV_View( $View );
		}

		if( in_array( $View, $this->views ) ) {
			return false;
		}

		$this->views[ $View->ID ] = $View;

		return true;
	}
}