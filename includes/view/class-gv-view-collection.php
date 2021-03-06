<?php
namespace GV;

/**
 * Hold all the Views
 */
final class View_Collection extends \ArrayIterator {

	/**
	 * @var View_Collection
	 */
	private static $instance;


	public function __construct( Mission_Control $GV_Mission_Control, $flag = 2 ) {
		parent::__construct( array(), $flag );
	}

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
	 * @return View[]
	 */
	function get_views() {
		return $this->getArrayCopy();
	}

	/**
	 * Alias of valid()
	 *
	 * @see valid
	 *
	 * @return bool
	 */
	function has_views() {
		return $this->valid();
	}

	/**
	 * Get a single GV View, if it exists in the collection
	 *
	 * @param int $id View ID to get
	 * @param bool $add_if_not_found Whether to add the View if not already in the View collection
	 *
	 * @return View
	 */
	function & get( $id, $add_if_not_found = true ) {

		$views_found = wp_list_pluck( $this->get_views(), 'ID' );

		if( empty( $views_found ) && $add_if_not_found ) {
			$this->add( $id );
		}

		$found_views = $this->get_views();

		foreach ( $found_views as $key => $view ) {
			if( intval( $id ) !== intval( $view->ID ) ) {
				unset( $found_views[ $key ] );
			}
		}

		return empty( $found_views ) ? NULL : $found_views;
	}

	/**
	 * @param int|\GV\View|\WP_Post|int[]|\GV\View[]|\WP_Post[] $view_to_add View ID, View object, WP Post object, or array consisting of those types
	 * @param array|string Array of overrides for View settings, or a string formatted for {@see wp_parse_atts()}
	 *
	 * @return View|false View is returned if added successfully. Otherwise, false: already existed or not ready to add
	 */
	function & add( $view_to_add, $atts = array() ) {

		// Handle the array of
		if( is_array( $view_to_add ) ) {
			foreach ( $view_to_add as $view ) {
				$this->add( $view, $atts );
			}
			unset( $view );
		}

		// Make sure the $View is a View
		if( ! $view_to_add instanceof View ) {
			$view_to_add = new View( $view_to_add, $atts );
		}

		if( ! $this->is_ready_to_add( $view_to_add ) ) {
			return false;
		}

		$this->offsetSet( $view_to_add->get_hash(), $view_to_add );

		return $view_to_add;
	}

	/**
	 * Alias - here for IDE purposes (return is helpful)
	 * @return View
	 */
	public function current() {
		return parent::current();
	}

	/**
	 * Does the View have some basic stuff: does it exist, does it have a connected form, etc.
	 *
	 * @param View $view_to_add
	 *
	 * @return bool
	 */
	private function is_ready_to_add( \GV\View $view_to_add ) {

		// Use the hash to see if a View with the same settings has already been added
		if( $this->offsetExists( $view_to_add->get_hash() ) ) {
			do_action('gravityview_log_debug', sprintf('%s: Returning; View #%s with the same configuration already exists.', __METHOD__, $view_to_add->ID ) );
			return false;
		}

		// View isn't in the DB
		if( ! $view_to_add->exists() ) {
			do_action('gravityview_log_debug', sprintf('%s: Returning; View #%s does not exist.', __METHOD__, $view_to_add ) );
			return false;
		}

		// View has no connected form
		if( false === $view_to_add->get_form_id() ) {
			do_action('gravityview_log_debug', sprintf('GravityView_View_Data[add_view] Returning; Post ID #%s does not have a connected form.', $view_to_add ) );
			return false;
		}

		return true;
	}
}