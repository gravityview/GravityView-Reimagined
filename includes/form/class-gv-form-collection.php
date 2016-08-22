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

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 2.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'gravityview' ), '1.0' );
	}
	/**
	 * Disable unserializing of the class
	 *
	 * @since 2.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'gravityview' ), '1.0' );
	}

	private function __construct( Mission_Control $GV_Mission_Control ) {}

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
	 * Get a Form object
	 *
	 * @param int $id Form ID
	 *
	 * @return \GV\Form Returns a reference
	 */
	function &get( $id ) {

		if( ! isset( $this->forms[ $id ] ) ) {
			$this->add( $id );
		}

		return $this->forms[ $id ];
	}

	/**
	 * Add a form to this
	 * @param int $id
	 * @return bool True: form added; False: form already added
	 */
	function add( $id = 0 ) {

		if( isset( $this->forms[ $id ] ) ) {
			return false;
		}

		$this->forms[ $id ] = new Form( $id );

		return true;
	}
}