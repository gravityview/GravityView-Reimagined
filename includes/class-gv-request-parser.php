<?php

/**
 * Handle parsing the post data to determine what content exists
 */
class GV_Request_Parser {

	/**
	 * Is the currently viewed post a `gravityview` post type?
	 * @var boolean
	 */
	private $is_gravityview_post_type = false;

	/**
	 * Does the current post have a `[gravityview]` shortcode?
	 * @var boolean
	 */
	private $post_has_shortcode = false;

	/**
	 * Are we currently viewing a single entry?
	 * @var boolean
	 */
	private $is_single_entry = false;

	/**
	 * @var GV_Request_Parser
	 */
	private static $instance;

	/**
	 * @return GV_Request_Parser
	 */
	public static function get_instance() {

		if( empty( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Add hooks
	 */
	private function __construct() {

		$this->initialize();

	}

	/**
	 * Add the hooks to parse the content
	 */
	private function initialize() {

		add_action( 'wp', array( $this, 'action_wp' ) );
	}

	/**
	 * @return bool
	 */
	function is_gravityview_post_type( $post = null ) {

		if( $post ) {
			return get_post_type( $post ) === 'gravityview';
		}

		/** @global WP_Query $wp_query */
		global $wp_query;

		return $wp_query->get('post_type') === 'gravityview';
	}

	/**
	 * Process the $post data as soon as it's set up
	 *
	 * @param WP $WP
	 */
	function action_wp( &$WP ) {
		global $post;

		// TODO: @tommcfarlin - Where is a better place / What's a better way to do this?
		if( $this->is_gravityview_post_type( $post ) ) {
			gravityview()->views->add( $post );
		}

		$this->post_has_shortcode = $this->_post_has_shortcode( $post );

	}

	/**
	 * Check whether the post has GV shortcode or not.
	 *
	 * @param WP_Post $post The Post object
	 *
	 * @return bool|null True/False if non-GV CPT post has shortcode. NULL if is GV CPT.
	 */
	function _post_has_shortcode( $post ) {

		if( $this->is_gravityview_post_type ) {
			return NULL;
		}

		$post_has_shortcode = !empty( $post->post_content ) ? gravityview_has_shortcode_r( $post->post_content, 'gravityview' ) : false;

		return !empty( $post_has_shortcode );

	}

}