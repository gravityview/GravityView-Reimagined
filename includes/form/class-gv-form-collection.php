<?php
namespace GV;

/**
 * Hold all the forms used by the Views
 */
final class Form_Collection {

	/**
	 * @var Form[]
	 */
	var $forms;

	/**
	 * @var Form_Collection
	 */
	private static $instance;

	private function __construct( GV_Mission_Control $GV_Mission_Control ) {}

	/**
	 * We only want one collection of forms
	 *
	 * @return Form_Collection
	 */
	public static function get_instance( Mission_Control $GV_Mission_Control ) {

		if( empty( self::$instance ) ) {
			self::$instance = new self( $GV_Mission_Control );
		}

		return self::$instance;
	}

	/**
	 * @param $id
	 *
	 * @return \GV\Form Returns a reference
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