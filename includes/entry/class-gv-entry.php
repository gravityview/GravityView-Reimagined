<?php
namespace GV;

use WP_Post;

/**
 * Class Entry
 * Can be used as an array, because it extends ArrayObject
 */
final class Entry extends \ArrayObject {

	const ARRAY_AS_PROPS = 2;

	/**
	 * The entry ID
	 * @var_dump int
	 */
	public $ID;

	/**
	 * The entry slug. May be the same as the $id
	 * @var int|string
	 */
	var $slug;

	/**
	 *
	 * @param int|string|array $id_slug_or_array int: entry ID; array: entry array; string: GravityView entry slug
	 */
	function __construct( $id_slug_or_array ) {

		$data = $this->setup( $id_slug_or_array );

		parent::__construct( $data );
	}

	private function setup( $id_slug_or_array ) {
		if( is_array( $id_slug_or_array ) ) {

			$entry_data = $id_slug_or_array;
			$entry_id = rgar( $id_slug_or_array, 'id' );
			$entry_slug = $entry_id;
		} else {
			$entry_id = $id_slug_or_array;
			$entry_slug = $entry_id;

			if( ! is_numeric( $id_slug_or_array ) ) {
				$entry_id = \GVCommon::get_entry_id_from_slug( $id_slug_or_array );
			}

			$entry_data = \GFAPI::get_entry( $entry_id );
		}

		$this->slug    = $entry_slug;
		$this->ID      = $entry_id;

		return $entry_data;
	}

	/**
	 * Fetch fresh data from GF
	 */
	public function refresh() {

		$entry = \GFAPI::get_entry( $this->ID );

		$this->setup( $entry );
	}

	/**
	 * Return an array representation.
	 *
	 * @since 3.5.0
	 *
	 * @return array Array representation.
	 */
	public function to_array() {
		return $this->storage;
	}

	public function __set( $property, $value ) {
		$this->offsetSet( $property, $value );
	}

	public function __get( $property ) {
		return $this->offsetGet( $property );
	}

	/**
	 * @param int|\WP_User|false $format "id" returns the User ID who created the entry. 'wp_user' returns a WP_User object for that user.
	 *
	 * @return false|null|string|\WP_User
	 */
	public function get_created_by( $format = 'id' ) {

		$created_by = $this->__get( 'created_by' );

		switch( strtolower( $format ) ) {
			case 'wp_user':
			case 'object':
				$return = get_userdata( $created_by );
				break;
			default:
				$return = intval( $created_by );
		}

		return $return;
	}

	public function get_form_id() {
		return intval( $this->__get( 'form_id' ) );
	}

	public function get_status() {
		return $this->__get( 'status' );
	}

	public function get_ip() {
		return $this->__get( 'ip' );
	}

	/**
	 * @return int|null
	 */
	public function get_post_id() {
		return $this->__get( 'post_id' );
	}

	/**
	 * If the entry has a connected post, get it
	 *
	 * @return null|WP_Post null if no connected post; WP_Post otherwise
	 */
	public function get_post() {
		$post_id = $this->__get( 'post_id' );

		if ( empty( $post_id ) ) {
			return null;
		}

		return get_post( $post_id );
	}

	public function is_starred() {
		return (bool) $this->__get( 'is_starred' );
	}

	public function is_read() {
		return (bool) $this->__get( 'is_read' );
	}

	function get_meta() {
		return \GVCommon::get_entry_meta( $this->ID );
	}

	/**
	 * @internal To be developed
	 * TODO: Integrate with ratings & reviews
	 */
	protected function get_reviews() {}

	/**
	 * @return \GV\Form Returns a form (by reference)
	 */
	public function &get_form() {
		return gravityview()->forms->get( $this->get_form_id() );
	}

	/**
	 * @return array Array of the attached GV_Form object
	 */
	public function get_form_array() {
		return $this->get_form()->to_array();
	}

	/**
	 * Get a Gravity Forms field object from the Field ID
	 *
	 * @param string|int $field_id The input id (4.2) or field ID (4)
	 *
	 * @return \GF_Field|null If form fields aren't set, return null. Otherwise, return Field ID
	 */
	function get_field( $field_id ) {
		return \GFFormsModel::get_field( $this->form, $field_id );
	}

	// Work In Progress
	function get_display_value( $input_id ) {
		$field = $this->get_field( $input_id );

		$value = $this->__get( $input_id );

		return \GFCommon::get_lead_field_display( $field, $value );
	}

	/**
	 * Returns the entry slug. Most often the same as get_id(), unless using custom entry slug
	 *
	 * @see \GravityView_API::get_entry_slug() gravityview_custom_entry_slug filter
	 *
	 * @return int|string
	 */
	function get_slug() {
		return $this->slug;
	}

	/**
	 * Returns the entry ID
	 * @return mixed
	 */
	function get_id() {
		return $this->ID;
	}

}