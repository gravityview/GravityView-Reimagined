<?php
namespace GV;
use GV;

/**
 * Holds the View data, including settings
 */
final class View {

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

		$this->settings = new View_Settings( $this, $atts );

		$this->template = new GV_Template( $this );

	/**
	 * Get a hash of a View based on the settings, not the entries it contains. Used to determine uniqueness.
	 *
	 * @see View_Collection::is_ready_to_add()
	 * @return string hash of the View, used to determine uniqueness
	 */
	function get_hash() {
		return sprintf( '%d-%s', $this->ID, sha1( serialize( array( $this->settings, $this->search_criteria, $this->template ) ) ) );
	}

		$this->search_criteria = new GV_View_Search_Criteria( $this );

		$this->set_entries();
	}

	function set_entries() {

		// TODO: use search_criteria
		$entries = GravityView_frontend::get_view_entries( array( 'id' => $this->ID ), $this->settings->get_form_id() );
			$this->entry_collection = new Entry_Collection( $entries );

	}

}