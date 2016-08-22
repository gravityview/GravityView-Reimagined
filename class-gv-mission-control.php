<?php
namespace GV;

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

		spl_autoload_register( array( $this, 'autoloader' ) );

		$this->setup_constants();

		$this->include_files();

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
	 * @param string $class_name
	 */
	function autoloader( $class_name = '' ) {
		
		$class_name = explode( 'GV\\', $class_name );

		if ( 1 === sizeof( $class_name ) ) {
			return;
		}

		$class_name = $class_name[1];

		$class_name_parts = explode( '_', $class_name );

		// \GV\Search_(.*) will be in /search/
		// \GV\Template_(.*) will be in /template/
		$directory_name = strtolower( $class_name_parts[0] );

		$file_name = str_replace( 'GV\\', '', $class_name );
		$file_name = str_replace( '_', '-', $file_name );

		$file_names = array(
			sprintf( 'abstract-gv-%s.php', strtolower( $file_name ) ), // It could be an abstract class
			sprintf( 'class-gv-%s.php', strtolower( $file_name ) ),
		);

		foreach ( $file_names as $name ) {
			$file_path = GV_DIR . sprintf( 'includes/%s/%s', $directory_name, $name );
			if( file_exists( $file_path ) ) {
				include $file_path;
			}
		}

	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 2.0
	 * @return void
	 */
	private function include_files() {
		require_once GV_DIR . 'includes/common-functions.php';
		require_once GV_DIR . 'includes/entry/entry-functions.php';
		require_once GV_DIR . 'includes/form/form-functions.php';
		require_once GV_DIR . 'includes/view/view-functions.php';
		require_once GV_DIR . 'includes/template/template-functions.php';
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