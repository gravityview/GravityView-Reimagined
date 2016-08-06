<?php
namespace GV;
use GV;

/**
 * Processes and holds data related to the current request.
 *
 * The goal here is to not have GV_Mission_Control even consider whether the current page is a CPT or embed; all that is
 * handled by the Request_Parser class.
 *
 */
final class Mission_Control {

	/**
	 * Holds the View data, which in turn has entries and settings
	 * @var View_Collection
	 */
	var $views;

	/**
	 * Hold forms that have been requested
	 * @var Form_Collection
	 */
	var $forms;

	/**
	 * Handles processing the request
	 * @var Request_Parser
	 */
	var $parser;

	/**
	 * Store meta data for the current page
	 * @var Page_Meta
	 */
	var $page_meta;

	/**
	 * @var Mission_Control
	 */
	private static $instance;

	private function __construct() {

		$this->setup_constants();
		$this->includes();

		$this->views     = View_Collection::get_instance( $this );
		$this->forms     = Form_Collection::get_instance( $this );
		$this->parser    = Request_Parser::get_instance( $this );
		$this->page_meta = Page_Meta::get_instance( $this );

		// TODO: Current View
		// TODO: Current field
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
	 * @return Mission_Control
	 */
	public static function get_instance() {

		if ( empty( self::$instance ) ) {
			self::$instance = new Mission_Control;
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
		require_once GV_DIR . 'includes/template/class-gv-template-context.php';
		require_once GV_DIR . 'includes/template/abstract-gv-template-item.php';
		require_once GV_DIR . 'includes/template/class-gv-template-field.php';
		require_once GV_DIR . 'includes/template/class-gv-template-widget.php';
		require_once GV_DIR . 'includes/template/abstract-gv-template-zone.php';
		require_once GV_DIR . 'includes/template/class-gv-template-fields-zone.php';
		require_once GV_DIR . 'includes/template/class-gv-template-widgets-zone.php';
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