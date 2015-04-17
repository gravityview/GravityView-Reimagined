<?php

/**
 * Holds the View data, including settings
 */
class GV_View {

	/**
	 * The ID of the View. May be the same as $post_id
	 * @var int
	 */
	var $ID;

	/**
	 * Hold the post data
	 * @var WP_Post
	 */
	var $post;

	/**
	 * @var GV_Entry_Collection
	 */
	var $entry_collection;

	/**
	 * @param int|WP_Post $post_or_post_id
	 */
	function __construct( $post_or_post_id = 0 ) {

		$this->post = get_post( $post_or_post_id );

		$this->ID = $this->post->ID;

		$this->settings = new GV_View_Settings( $this );

		$this->template = new GV_Template( $this );

		$this->search_criteria = new GV_View_Search_Criteria( $this );

		$this->set_entries();
	}

	function set_entries() {

		// TODO: use search_criteria
		$entries = GravityView_frontend::get_view_entries( array( 'id' => $this->ID ), $this->settings->get_form_id() );

		$this->entry_collection = new GV_Entry_Collection( $entries['entries'] );
	}

}