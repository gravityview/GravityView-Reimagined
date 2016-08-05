<?php
namespace GV;
use GV;

/**
 * Hold all the Views
 */
final class View_Collection extends \ArrayIterator {

	/**
	 * @var View_Collection
	 */
	var $views = array();

	private static $instance;


	public function __construct( Mission_Control $GV_Mission_Control, $flag = 2 ) {}

	/**
	 * @return View_Collection
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
	 * @return View
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

		// Make sure the $View is a \GV\View
		if( ! $view_to_add instanceof \GV\View ) {
			$view_to_add = new View( $view_to_add, $atts );
		}

		$this->offsetSet( $view_to_add->get_hash(), $view_to_add );
			return false;
		}

		$this->views[ $View->ID ] = $View;

		return true;
	}
}