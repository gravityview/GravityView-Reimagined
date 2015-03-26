<?php
//
// GravityView Refactoring Example
//
// NOT A REAL PLUGIN YET, SO NO REAL DOCBLOCK
//
// Version: 2.0-bleeding-edge
//

function gravityview() {
	return GV_Mission_Control::get_instance();
}

/**
 * Processes and holds data related to the current request.
 *
 * The goal here is to not have GV_Mission_Control even consider whether the current page is a CPT or embed; all that is
 * handled by the GV_Request_Parser class.
 *
 */
final class GV_Mission_Control {

	/**
	 * Holds the View data, which in turn has entries and settings
	 * @var GV_View_Collection
	 */
	var $views;

	/**
	 * Hold forms that have been requested
	 * @var GV_Form_Collection
	 */
	var $forms;

	/**
	 * Handle processing the request
	 * @var GV_Request_Parser
	 */
	var $parser;

	/**
	 * @var GV_Mission_Control
	 */
	private static $instance;

	private function __construct() {}

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

	/**
	 * @return GV_Request
	 */
	public static function get_instance() {

		if ( empty( self::$instance ) ) {

			self::$instance = new GV_Mission_Control;

			self::$instance->setup_constants();
			self::$instance->includes();

			self::$instance->views  = GV_View_Collection::get_instance( $this );
			self::$instance->forms  = GV_Form_Collection::get_instance( $this );
			self::$instance->parser = GV_Request_Parser::get_instance( $this );

		}

		return self::$instance;
	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 2.0
	 * @return void
	 */
	private function includes() {

		require_once GRAVITYVIEW_DIR . 'includes/class-gv-entry.php';
		require_once GRAVITYVIEW_DIR . 'includes/class-gv-entry-collection.php';

		require_once GRAVITYVIEW_DIR . 'includes/class-gv-form.php';
		require_once GRAVITYVIEW_DIR . 'includes/class-gv-form-collection.php';

		require_once GRAVITYVIEW_DIR . 'includes/class-gv-view.php';
		require_once GRAVITYVIEW_DIR . 'includes/class-gv-view-search-criteria.php';
		require_once GRAVITYVIEW_DIR . 'includes/class-gv-view-settings.php';
		require_once GRAVITYVIEW_DIR . 'includes/class-gv-view-collection.php';

	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 2.0
	 * @return void
	 */
	private function setup_constants() {

		if ( ! defined( 'GRAVITYVIEW_FILE' ) ) {
			define( 'GRAVITYVIEW_FILE', __FILE__ );
		}

		if ( ! defined( 'GRAVITYVIEW_URL' ) ) {
			define( 'GRAVITYVIEW_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'GRAVITYVIEW_DIR' ) ) {
			define( 'GRAVITYVIEW_DIR', plugin_dir_path( __FILE__ ) );
		}

		// GravityView requires at least this version of Gravity Forms to function properly.
		if ( ! defined( 'GV_MIN_GF_VERSION' ) ) {
			define( 'GV_MIN_GF_VERSION', '1.9' );
		}

	}

}