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
	public $ID = 0;

	/**
	 * Hold the post data
	 * @var \WP_Post
	 */
	private $post = null;

	/**
	 * @var View_Settings Stores the settings for the View
	 */
	private $settings = null;

	/**
	 * @var Template
	 */
	private $template = null;

	/**
	 * @var Entry_Collection Set using {@see View::get_entries()}
	 */
	private $entry_collection = null;

	/**
	 * @param int|\WP_Post $post_or_post_id ID or full Post object
	 * @param array $atts
	 */
	function __construct( $post_or_post_id = 0, $atts = array() ) {

		$this->post = get_post( $post_or_post_id );

		$this->ID = $this->post->ID;

		$this->settings = new View_Settings( $this, $atts );

		$this->template = new Template( $this );

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

	public function get_settings() {
		return $this->settings->get_settings();
	}

	public function get_setting( $key ) {
		return $this->settings->get( $key );
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

	/**
	 * @return int ID of the View CPT
	 */
	public function get_id() {
		return $this->ID;
	}

	/**
	 * Get the Gravity Forms form ID connected to a View
	 *
	 * @param int $view_id The ID of the View to get the connected form of
	 *
	 * @return false|string ID of the connected Form, if exists. Empty string if not. False if not the View ID isn't valid.
	 */
	function get_form_id() {
		return get_post_meta( $this->get_id(), '_gravityview_form_id', true );
	}

	/**
	 * Get the template ID (`list`, `table`, `datatables`, `map`) for a View
	 *
	 * @see GravityView_Template::template_id
	 *
	 * @param int $view_id The ID of the View to get the layout of
	 *
	 * @return string GravityView_Template::template_id value. Empty string if not.
	 */
	function get_template_id() {
		return get_post_meta( $this->get_id(), '_gravityview_directory_template', true );
	}

	/**
	 * @return \GV\Form Returns a reference
	 */
	function &get_form() {
		return gravityview()->forms->get( $this->get_form_id() );
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