<?php
namespace GV;

use ArrayObject;
use GFAPI;
use GVCommon;
use GFFormsModel;

/**
 * Interact with the Gravity Forms form array
 * Can be used as an array, because it extends ArrayObject
 */
final class Form extends ArrayObject {

	/**
	 * @param int|array $id_or_array ID of the form or GF form array
	 */
	function __construct( $id_or_array ) {

		if( ! is_array( $id_or_array ) && ! is_numeric( $id_or_array ) ) {
			// TODO: Exception
			return;
		}

		if ( ! is_array( $id_or_array ) ) {
			$form = GFAPI::get_form( $id_or_array );
		}

		if( false === $form ) {
			// TODO: Exception
			return;
		}

		parent::__construct( $form );
	}

	/**
	 * Return an array representation.
	 *
	 * @return array Array representation.
	 */
	public function to_array() {
		return $this->getArrayCopy();
	}

	/**
	 * @return array Form notifications
	 */
	public function get_notifications() {
		return $this->offsetGet( 'notifications' );
	}

	/**
	 * @return array Form confirmations
	 */
	public function get_confirmations() {
		return $this->offsetGet( 'confirmations' );
	}

	/**
	 * @return int Form ID
	 */
	public function get_id() {
		return intval( $this->offsetGet( 'id' ) );
	}

	/**
	 * @return string Form title
	 */
	public function get_title() {
		return $this->offsetGet( 'title' );
	}

	/**
	 * @return string Form description
	 */
	public function get_description() {
		return $this->offsetGet( 'description' );
	}

	/**
	 * Return array of fields' id and label, for a given Form ID
	 *
	 * @see GVCommon::get_form_fields
	 *
	 * @access public
	 * @param string|array $form_id (default: '') or $form object
	 * @return array
	 */
	function get_fields( $add_default_properties = false, $include_parent_field = true ) {
		return GVCommon::get_form_fields( $this->data, $add_default_properties, $include_parent_field_ );
	}

	/**
	 * Get a field by the field's ID
	 *
	 * @param $field_or_input_id
	 *
	 * @return \GF_Field
	 */
	function get_field_by_id( $field_or_input_id ) {
		return GFFormsModel::get_field( $this, $field_or_input_id );
	}

	/**
	 * @see \GVCommon::get_connected_views
	 * @return array
	 */
	function get_connected_views() {
		return GVCommon::get_connected_views( $this->id );
	}

	/**
	 * Should the field be considered "numeric"
	 *
	 * TODO: Improve this to handle many more field types and use cases
	 *
	 * @param string|int $field_id Field ID or field meta key
	 *
	 * @return bool
	 */
	public function is_field_numeric( $field_id = '' ) {

		// The default field is "id", which is numeric
		if( '' === $field_id || 'id' === $field_id ) {
			return true;
		}

		$field = $this->get_field_by_id( $field_id );

		return $field instanceof \GF_Field_Number;
	}
}