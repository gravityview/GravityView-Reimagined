<?php
/**
 * Plugin Name:       	GravityView Reloaded
 * Plugin URI:        	http://gravityview.co
 * Description:       	Create directories based on a Gravity Forms form, insert them using a shortcode, and modify how they output.
 * Version:          	2.0-bleeding-edge
 * Author:            	Katz Web Services, Inc.
 * Author URI:        	http://www.katzwebservices.com
 * Text Domain:       	gravityview
 * License:           	GPLv2 or later
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:			/languages
 */

function gravityview() {
	return GV_Mission_Control::get_instance();
}

gravityview();

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
	 * Handles processing the request
	 * @var GV_Request_Parser
	 */
	var $parser;

	/**
	 * Store meta data for the current page
	 * @var GV_Page_Meta
	 */
	var $page_meta;

	/**
	 * @var GV_Mission_Control
	 */
	private static $instance;

	private function __construct() {

		$this->setup_constants();
		$this->includes();

		$this->views     = GV_View_Collection::get_instance( $this );
		$this->forms     = GV_Form_Collection::get_instance( $this );
		$this->parser    = GV_Request_Parser::get_instance( $this );
		$this->page_meta = GV_Page_Meta::get_instance( $this );

	}

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
	 * @return GV_Mission_Control
	 */
	public static function get_instance() {

		if ( empty( self::$instance ) ) {
			self::$instance = new GV_Mission_Control;
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

		require_once GV_DIR . 'includes/common-functions.php';

		// Handle the request
		require_once GV_DIR . 'includes/class-gv-request-parser.php';

		// Entries
		require_once GV_DIR . 'includes/entry/class-gv-entry.php';
		require_once GV_DIR . 'includes/entry/class-gv-entry-collection.php';
		require_once GV_DIR . 'includes/entry/entry-functions.php';

		// Forms
		require_once GV_DIR . 'includes/form/form-functions.php';
		require_once GV_DIR . 'includes/form/class-gv-form.php';
		require_once GV_DIR . 'includes/form/class-gv-form-collection.php';

		// Views
		require_once GV_DIR . 'includes/view/view-functions.php';
		require_once GV_DIR . 'includes/view/class-gv-view.php';
		require_once GV_DIR . 'includes/view/class-gv-view-search-criteria.php';
		require_once GV_DIR . 'includes/view/class-gv-view-settings.php';
		require_once GV_DIR . 'includes/view/class-gv-view-collection.php';

		// Templates
		require_once GV_DIR . 'includes/template/template-functions.php';
		require_once GV_DIR . 'includes/template/class-gv-template.php';

		// Page
		require_once GV_DIR . 'includes/page/class-gv-page-meta.php';
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
			/** @define "GRAVITYVIEW_FILE" "./gv.php" */
			define( 'GRAVITYVIEW_FILE', __FILE__ );
		}

		if ( ! defined( 'GRAVITYVIEW_URL' ) ) {
			define( 'GRAVITYVIEW_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'GV_DIR' ) ) {
			/** @define "GV_DIR" "./" */
			define( 'GV_DIR', plugin_dir_path( __FILE__ ) );
		}

		// GravityView requires at least this version of Gravity Forms to function properly.
		if ( ! defined( 'GV_MIN_GF_VERSION' ) ) {
			define( 'GV_MIN_GF_VERSION', '1.9' );
		}

	}

}