<?php
namespace GV;
use GV;

/**
 * Interact with the Gravity Forms form array
 * Can be used as an array, because it extends ArrayObject
 */
final class Form extends \ArrayObject {

	/**
	 * @param int|array $id_or_array ID of the form or GF form array
	 */
	function __construct( $id_or_array ) {

		$form = is_array( $id_or_array ) ? $id_or_array : \GFAPI::get_form( $id_or_array );

		if( ! $form ) {
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

	public function get_notifications() {
		return $this->offsetGet( 'notifications' );
	}

	public function get_confirmations() {
		return $this->offsetGet( 'confirmations' );
	}

	public function get_id() {
		return $this->offsetGet( 'id' );
	}

	public function get_title() {
		return $this->offsetGet( 'title' );
	}

	public function get_description() {
		return $this->offsetGet( 'description' );
	}

	/**
	 * Return array of fields' id and label, for a given Form ID
	 *
	 * @see \GVCommon::get_form_fields
	 *
	 * @access public
	 * @param string|array $form_id (default: '') or $form object
	 * @return array
	 */
	function get_fields( $add_default_properties = false, $include_parent_field = true ) {
		return \GVCommon::get_form_fields( $this->data, $add_default_properties, $include_parent_field_ );
	}

	/**
	 * @see \GVCommon::get_connected_views
	 * @return array
	 */
	function get_connected_views() {
		return \GVCommon::get_connected_views( $this->id );
	}
}