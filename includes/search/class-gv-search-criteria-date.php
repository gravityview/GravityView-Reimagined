<?php
namespace GV;

class Search_Criteria_Date extends Search_Parameter {

	/**
	 * @var int strtotime version of the value
	 */
	var $timestamp;

	/**
	 * Search_Criteria_Date constructor.
	 *
	 * @param int $timestamp
	 */
	public function __construct( $value = null ) {

		$this->timestamp = strtotime( $value );

		parent::__construct( $value );
	}


	private function is_valid( $value = '' ) {

		$valid_date = strtotime( $value );

		return ( false !== $valid_date );
	}


}