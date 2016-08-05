<?php
namespace GV;
use GV;

/**
 * Handle parsing the post data to determine what content exists
 *
 * Is this a `gravityview` Custom Post Type?
 * If not, are there embedded `[gravityview]` shortcodes?
 *
 * TODO: What about AJAX requests!
 */
final class Request_Parser {

	/**
	 * Is the currently viewed post a `gravityview` post type?
	 * @var boolean
	 */
	private $is_cpt = false;

	/**
	 * Does the current post have a `[gravityview]` shortcode?
	 * @var boolean
	 */
	private $post_has_shortcode = false;

	/**
	 * What context are we in currently? `multiple`/`directory`, `single`, `edit`
	 * @var string
	 */
	private $context = '';

	/**
	 * @var bool
	 */
	private $entry_slug = false;

	/**
	 * @var Request_Parser
	 */
	private static $instance;

	/**
	 * @return Request_Parser
	 */
	public static function get_instance( Mission_Control $Mission_Control ) {

		if( empty( self::$instance ) ) {
			self::$instance = new self( $Mission_Control );
		}

		return self::$instance;
	}

	/**
	 * Add hooks
	 */
	private function __construct( Mission_Control $Mission_Control ) {
		$this->initialize();
	}

	/**
	 * Add the hooks to parse the content
	 */
	private function initialize() {
		add_action( 'wp', array( $this, 'setup_vars' ), 10 );
		add_action( 'wp', array( $this, 'process_views_from_request' ), 20 );
	}

	/**
	 * @param \WP $WP
	 */
	function setup_vars( &$WP ) {
		$this->is_cpt = $this->is_custom_post_type();
		$this->entry_slug = $this->is_single_entry();
		$this->context = $this->get_context();
	}

	/**
	 * Get the context for the current request
	 *
	 * @return string View context "directory", "single", or "edit"
	 */
	function get_context() {

		// Already set
		if( '' !== $this->context ) {
			return $this->context;
		}


		/**
		 * @filter `gravityview_is_edit_entry` Whether we're currently on the Edit Entry screen \n
		 * The Edit Entry functionality overrides this value.
		 * @param boolean $is_edit_entry
		 */
		$is_edit_entry = apply_filters( 'gravityview_is_edit_entry', false );

		$context = '';
		
		if( $is_edit_entry ) {
			$context = 'edit';
		} else if( class_exists( '\GravityView_frontend' ) && $single = \GravityView_frontend::is_single_entry() ) {
			$context = 'single';
		} else if( class_exists( 'GravityView_View' ) ) {
			$context = \GravityView_View::getInstance()->getContext();
		}

		return $context;
	}

	/**
	 * @return bool
	 */
	function is_custom_post_type( $post = null ) {
		/** @global \WP_Query $wp_query */
		global $wp_query;

		if( $post ) {
			return get_post_type( $post ) === 'gravityview';
		}


		return $wp_query->get('post_type') === 'gravityview';
	}

	/**
	 * Verify if user requested a single entry view
	 * @return boolean|string false if not single entry. Otherwise, a string of the entry slug or ID
	 */
	public function is_single_entry() {

		$var_name = \GravityView_Post_Types::get_entry_var_name();

		$single_entry = get_query_var( $var_name );

		/**
		 * Modify the entry that is being displayed.
		 *
		 * @internal Should only be used by things like the oEmbed functionality.
		 * @since 1.6
		 */
		$single_entry = apply_filters( 'gravityview/is_single_entry', $single_entry );

		if ( empty( $single_entry ) ){
			return false;
		} else {
			return $single_entry;
		}
	}

	/**
	 * Process the $post data as soon as it's set up
	 *
	 * @param \WP $WP
	 */
	public function process_views_from_request( &$WP ) {
		global $post;

		if( $this->is_custom_post_type( $post ) ) {
			gravityview()->views->add( $post );
		} else {

			$shortcodes = $this->parse_shortcodes( $post->post_content );

			$this->post_has_shortcode = ! empty( $shortcodes );

			foreach ( $shortcodes as $view_id => $view_atts ) {
				gravityview()->views->add( $view_id, $view_atts );
			}
		}

	}

	/**
	 * Parse the shortcodes in Post Content
	 *
	 * @param string $content
	 *
	 * @return array Associative array: (int)[View IDs] => (array)shortcode attributes
	 */
	public function parse_shortcodes( $content = '' ) {

		$shortcodes = has_shortcode_r( $content, 'gravityview' );

		$return = array();

		if( ! empty( $shortcodes ) ) {

			do_action('gravityview_log_debug', __METHOD__ . ': Parsing content, found shortcodes', $shortcodes );

			foreach ( $shortcodes as $key => $shortcode ) {

				$args = shortcode_parse_atts( $shortcode[3] );

				if ( empty( $args['id'] ) ) {
					continue;
				}

				$return[ $args['id'] ] = $args;
			}
		}

		return $return;
	}

	/**
	 * Check whether the post has GV shortcode or not.
	 *
	 * @param \WP_Post $post The Post object
	 *
	 * @return bool|null True/False if non-GV CPT post has shortcode. NULL if is GV CPT.
	 */
	private function post_has_shortcode( $post ) {

		if( $this->is_cpt ) {
			return NULL;
		}

		$post_has_shortcode = !empty( $post->post_content ) ? has_shortcode_r( $post->post_content, 'gravityview' ) : false;

		return !empty( $post_has_shortcode );

	}

}