<?php
namespace GV;

abstract class Search_Parameter {

	protected $value = NULL;

	protected $valid_values = NULL;

	function __construct( $value = null ) {

		// If the value is empty, do not try to set the value
		if ( '' === $value || array() === $value || is_null( $value ) ) {
			return;
		}
		
		if( $this->is_valid( $value ) ) {
			$this->value = $value;
		} else {
			throw new \Exception( 'Search Parameter value is not valid: ' . print_r( $value, true ) );
		}
	}

	public function __toString() {
		return $this->value;
	}

	/**
	 * Validate a value for the parameter.
	 *
	 * If $valid_values is an array, compare the passed value with the allowed values.
	 * If $valid_values is a string, use the string as a validation function, like `is_int()`
	 *
	 * @param string $value
	 *
	 * @return bool
	 */
	protected function is_valid( $value = '' ) {

		// No valid values have been set
		if ( is_null( $this->valid_values ) ) {
			return true;
		}

		// Callback validation, like 'is_int'
		if( is_string( $this->valid_values ) && function_exists( $this->valid_values ) ) {
			$function_name = $this->valid_values;
			return $function_name( $value );
		}

		if ( is_array( $this->valid_values ) && in_array( $value, $this->valid_values, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param mixed $value
	 */
	public function set( $value = '' ) {
		if( $this->is_valid( $value ) ) {
			$this->value = $value;
		}
	}

	/**
	 * @return mixed Value of the parameter
	 */
	public function get() {
		return $this->value;
	}

}