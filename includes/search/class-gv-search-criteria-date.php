<?php
namespace GV;

class Search_Criteria_Date extends Search_Parameter {

	private function is_valid( $value = '' ) {

		$valid_date = strtotime( $value );

		return ( false !== $valid_date );
	}
}