<?php

/**
 * Handle parsing the post data to determine what content exists
 */
class GV_Request_Parser {

	/**
	 * @var GV_Mission_Control
	 */
	private $GV_Mission_Control;

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
	public static function get_instance( GV_Mission_Control $GV_Mission_Control ) {

		if( empty( self::$instance ) ) {
			self::$instance = new self( $GV_Mission_Control );
		}

		return self::$instance;
	}

	/**
	 * Add hooks
	 */
	private function __construct( GV_Mission_Control $GV_Mission_Control ) {

		$this->GV_Mission_Control = $GV_Mission_Control;

		$this->initialize();

	}

	/**
	 * Add the hooks to parse the content
	 */
	private function initialize() {

		// Handle all get_posts() requests to set the post type as early as possible
		add_action( 'pre_get_posts', array( $this, 'action_pre_get_posts' ) );

		// Handle all get_posts() requests to set the post type as early as possible
		add_action( 'the_post', array( $this, 'action_the_post' ) );
	}

	/**
	 * Process the posts query as soon as it's prepared
	 *
	 * @param WP_Query $WP_Query The WP_Query instance, passed by reference
	 */
	function action_pre_get_posts( &$WP_Query ) {
		add_action( 'pre_get_posts', array( $this, 'action_pre_get_posts' ) );

	}

	/**
	 * @return bool
	 */
	function is_gravityview_post_type() {
		/** @global WP_Query $wp_query */
		global $wp_query;

		return $wp_query->get('post_type') === 'gravityview';
	}

	/**
	 * Process the $post data as soon as it's set up
	 *
	 * @param WP_Post &$post The Post object (passed by reference).
	 */
	function action_the_post( &$post ) {

		// TODO: @tommcfarlin - Where is a better place / What's a better way to do this?
		if( $this->is_gravityview_post_type() ) {
			$this->GV_Mission_Control->views->add( $post );
		}

		$this->post_has_shortcode = $this->_post_has_shortcode( $post );

		// Only process for the main `the_post` request, not for subsequent requests
		// TODO: @tom - this is an example of the crappy hacks I want to get rid of!
		// It was recursive with the $this->GV_Mission_Control->views->add( $post ); call
		remove_action( 'the_post', array( $this, 'action_the_post' ) );
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