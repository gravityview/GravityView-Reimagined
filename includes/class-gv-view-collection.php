<?php

/**
 * Hold all the Views
 */
class GV_View_Collection {

	/**
	 * @var GV_Mission_Control
	 */
	private $GV_Mission_Control;

	/**
	 * @var GV_View[]
	 */
	var $views;

	private static $instance;

	private function __construct( GV_Mission_Control $GV_Mission_Control ) {
		$this->GV_Mission_Control = $GV_Mission_Control;
	}

	/**
	 * @return GV_View_Collection
	 */
	public static function get_instance( GV_Mission_Control $GV_Mission_Control ) {

		if( empty( self::$instance ) ) {
			self::$instance = new self( $GV_Mission_Control );
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
	 */
	function add( GV_View $View ) {

		if( in_array( $View, $this->views ) ) {
			return;
		}

		$this->views[ $View->id ] = $View;
	}
}