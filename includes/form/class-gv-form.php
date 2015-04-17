<?php

/**
 * Interact with the Gravity Forms form array
 * Can be used as an array, because the magic functions.
 */
class GV_Form {


	private $_data;

	/**
	 * @param int|array $id_or_array ID of the form or GF form array
	 */
	function __construct( $id_or_array ) {

		$form = is_array( $id_or_array ) ? $id_or_array : GVCommon::get_form( $id_or_array );

		// Map the form data
		foreach( $form as $key => $value ) {
			$this->__set( $key, $value );
		}

	}

	/**
	 * Magic method to set the property using array notation
	 *
	 * @param $property
	 * @param $value
	 *
	 * @return mixed
	 */
	public function __set( $property, $value ) {
		return $this->_data[ $property ] = $value;
	}

	/**
	 * Magic method to get the property using array notation
	 *
	 * @param $property
	 * @param $value
	 *
	 * @return mixed
	 */
	public function __get( $property ) {
		if ( array_key_exists( $property, $this->_data ) ) {
			return $this->_data[ $property ];
		}

		return NULL;
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
		return GVCommon::get_form_fields( $this->_data, $add_default_properties, $include_parent_field_ );
	}

	/**
	 * @see GVCommon::get_connected_views
	 * @return array
	 */
	function get_connected_views() {
		return GVCommon::get_connected_views( $this->id );
	}
}