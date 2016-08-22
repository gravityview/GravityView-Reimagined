<?php
namespace GV;

use ArrayObject;

/**
 * The search array includes keys that have fixed allowed values: `paging` has `offset` and `page_size` keys; no other
 * keys are valid. Those keys have valid values as well: anything other than integers are not allowed.
 *
 * Each of the allowed keys has a class name
 *
 * This collection class is shared by the following classes:
 *
 * @see Search_Criteria_Filter
 * @see Search_Criteria_Paging
 * @see Search_Criteria_Sorting
 *
 * @package GV
 */
abstract class Search_Parameter_Collection extends ArrayObject {

	/**
	 * @var array The allowed keys and default values for those keys
	 */
	protected static $defaults = array();

	/**
	 * Search_Criteria_Filter constructor.
	 *
	 * @param array
	 */
	public function __construct( $passed_values = NULL ) {

		$values = wp_parse_args( $passed_values, static::$defaults );

		foreach ( $values as $key => $value ) {
			$this->offsetSet( $key, $value );
		}
	}

	/**
	 * Append the name of the key to the name of the current class
	 *
	 * The `Search_Criteria_Paging` class, setting the value for `offset` key => Search_Criteria_Paging_Offset
	 *
	 * @param string $key key being set
	 *
	 * @return string The name of the Search_Parameter subclass for the specified key
	 */
	private function get_key_class_name( $key ) {
		return get_class( $this ) . '_' . ucfirst( $key );
	}

	public function offsetSet( $key, $newval ) {

		$class_name = $this->get_key_class_name( $key );

		if ( ! array_key_exists( $key, static::$defaults ) ) {
			throw new \Exception( 'Key does not exist' );
		}

		if ( ! class_exists( $class_name ) ) {
			throw new \Exception( 'Class does not exist: ' . $class_name );
		}

		$this->{$key} = new $class_name( $newval );
	}

	public function set( $key, $newval ) {
		$this->offsetSet( $key, $newval );
	}

	/**
	 * @param $key
	 *
	 * @return string
	 */
	public function get( $key ) {
		$value = null;

		if( isset( $this->{$key} ) ) {
			$value = $this->{$key}->get();
		}

		return $value;
	}

	/**
	 * Override the parent function to return dynamic values from the Search_Parameter class
	 *
	 * @see Search_Parameter
	 *
	 * @return array
	 */
	public function getArrayCopy() {

		$return = array();

		foreach ( static::$defaults as $key => $default_value ) {
			if( isset( $this->{$key} ) ) {
				$return["{$key}"] = $this->get( $key );
			}
		}

		return $return;
	}

	public function to_array() {
		return $this->getArrayCopy();
	}
}