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
	function __construct( $post_or_post_id = 0, $atts = array() ) {

		$this->post = get_post( $post_or_post_id );

		$this->ID = $this->post->ID;

		$this->settings = new View_Settings( $this, $atts );

		$this->template = new GV_Template( $this );
		// TODO: Set deafults first, then can be overridden by set_search_criteria
		$this->search_criteria = new View_Search_Criteria( $this );
	}

	/**
	 * Get a hash of a View based on the settings, not the entries it contains. Used to determine uniqueness.
	 *
	 * @see View_Collection::is_ready_to_add()
	 * @return string hash of the View, used to determine uniqueness
	 */
	function get_hash() {
		return sprintf( '%d-%s', $this->ID, sha1( serialize( array( $this->settings, $this->search_criteria, $this->template ) ) ) );
	}

	/**
	 * Override the search criteria defaults
	 *
	 * $View = new GV_View(5);
	 * $Search = new GV_View_Search_Criteria( array( 'fo
	 * $View->set_search_criteria( $search );
	 *
	 * @param View_Search_Criteria|array $search_criteria Either GF-formatted array or Search_Criteria object
	 */
	public function set_search_criteria( $search_criteria ) {

		if( is_array( $search_criteria ) ) {
			$search_criteria = new View_Search_Criteria( $search_criteria );
		}

		if( ! is_a( $search_criteria, '\GV\View_Search_Criteria' ) ) {
			do_action('gravityview_log_debug', sprintf('%s: Search criteria not valid.', __METHOD__, $search_criteria ) );
			return false;
		}

		$this->search_criteria = $search_criteria;

		return true;
	}


	/**
	 * Does the View exist as a post type in the database?
	 *
	 * Note: it may still be in the Trash, even if it exists.
	 *
	 * @return bool True: exists; False: does not exist
	 */
	public function exists() {
		return ! empty( $this->ID ) && gravityview_view_exists( $this->ID );
	}
	}

	/**
	 * @return Entry_Collection
	 */
	function get_entries() {

		if ( empty( $this->entry_collection ) ) {
			// TODO: use search_criteria
			$entries = \GravityView_frontend::get_view_entries( array( 'id' => $this->ID ), $this->get_form_id() );
			$entries = \GFAPI::get_entries( $this->get_form_id() );

			$this->entry_collection = new Entry_Collection( $entries );
		}

		return $this->entry_collection;
	}

}