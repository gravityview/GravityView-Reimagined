<?php
namespace GV;

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
		$this->search_criteria = new Search_Criteria_View( $this );
	}

	/**
	 * @return Template_Context[]
	 */
	function get_contexts() {
		return $this->template->get_contexts();
	}

	/**
	 * @param string $context
	 *
	 * @return Template_Context
	 */
	function get_context( $context = '' ) {

		if( empty( $context ) ) {
			$context = gravityview()->parser->get_context();
		}

		$contexts = $this->get_contexts();
		
		return $contexts["{$context}"];
	}

	/**
	 * Get a hash of a View based on the settings, not the entries it contains. Used to determine uniqueness.
	 *
	 * @see View_Collection::is_ready_to_add()
	 * @return string Hash of the View, used to determine uniqueness. In following format: "{View ID}-{hash}"
	 */
	function get_hash() {
		return sprintf( '%d-%s', $this->ID, substr( hash( 'md4', serialize( array( $this->settings, $this->search_criteria, $this->template ) ) ), 0, 16 ) );
	}

	/**
	 * Override the search criteria defaults
	 *
	 * $View = new GV_View(5);
	 * $Search = new Search_Criteria( array( 'fo
	 * $View->set_search_criteria( $search );
	 *
	 * @param Search_Criteria|array $search_criteria Either GF-formatted array or Search_Criteria object
	 */
	public function set_search_criteria( $search_criteria ) {

		if( is_array( $search_criteria ) ) {
			$search_criteria = new Search_Criteria_View( $this, $search_criteria );
		}

		if( ! is_a( $search_criteria, '\GV\Search_Criteria_View' ) ) {
			do_action('gravityview_log_debug', sprintf('%s: Search criteria not valid.', __METHOD__, $search_criteria ) );
			return false;
		}

		$this->search_criteria = $search_criteria;

		return true;
	}

	/**
	 * @return array
	 */
	public function get_settings() {
		return $this->settings->get_settings();
	}

	/**
	 * @param string $key Key to the setting requested
	 *
	 * @return mixed|false The value at the specified index or false.
	 */
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

	function set_entries( $entries = array() ) {

		if( array() === $entries ) {
			$gv_search = new Search( $this->get_form_id(), $this->search_criteria );

			$this->entry_collection = $gv_search->get_entries();
		} else {
			$this->entry_collection = new Entry_Collection( $entries );
		}
	}

	/**
	 * @return Entry_Collection
	 */
	function &get_entries() {

		if ( ! isset( $this->entry_collection ) ) {
			$this->set_entries();
		}

		return $this->entry_collection;
	}

	/**
	 * @param bool $echo Whether to print the output. If false, only return the output.
	 *
	 * @return string Rendered output
	 */
	function render( $echo = true ) {

		ob_start();

		echo '<h3>Testing from ' . __METHOD__ . '</h3>';

		/** @var \GV\Entry $entry */
		foreach( $this->get_entries() as $entry ) {
			printf( 'Entry ID: %d connected to form %d created by %s <br />', $entry->get_id(), $entry->get_form_id(), $entry->get_created_by('wp_user')->display_name );
		}

		/** @var \GV\Template_Widgets_Zone $zone */
		$footer = $this->get_context()->get_widget_location( 'footer' );

		foreach ( $footer as $location => $zone ) {
			echo "<h3>Rendering footer widget zone: {$location}</h3>";
			$zone->render();
		}

		$rendered = ob_get_clean();

		if( $echo ) {
			echo $rendered;
		}

		return $rendered;
	}

}