<?php

/**
 * Hold all the forms used by the Views
 */
class GV_Form_Collection {

	/**
	 * @var GV_Form[]
	 */
	var $forms;

	/**
	 * @var GV_Form_Collection
	 */
	private static $instance;

	private function __construct( GV_Mission_Control $GV_Mission_Control ) {}

	/**
	 * @return GV_Form_Collection
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
	 * @return GV_Form
	 */
	function get( $id ) {

		if( !isset( $this->forms[ $id ] ) ) {
			$this->add( $id );
		}

		return $this->forms[ $id ];
	}

	/**
	 * @param int $id
	 */
	function add( $id = 0 ) {

		if( isset( $this->forms[ $id ] ) ) {
			return;
		}

		$this->forms[ $id ] = new GV_Form( $id );
	}
}