<?php

/**
 * Holds the View data, including settings
 */
class GV_View {

	/**
	 * The ID of the View. May be the same as $post_id
	 * @var int
	 */
	var $id;

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

		$this->settings = new GV_View_Settings( $this );

		$this->template = new GV_Template( $this );

	}

	function set_entries( GV_Entry_Collection $GV_Entry_Collection ) {
		$this->entry_collection = $GV_Entry_Collection;
	}

}