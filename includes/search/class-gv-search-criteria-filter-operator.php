<?php
namespace GV;

class Search_Criteria_Filter_Operator extends Search_Parameter {

	protected $value = 'contains';

	private static $SCALAR_OPERATORS = array( 'is', '=', 'isnot', '<>', 'contains', 'starts_with', 'ends_with' );

	private static $NUMERIC_OPERATORS = array( 'is', '=', '!=', 'isnot', 'greater_than', '>', 'less_than', '<' );

	private static $ARRAY_OPERATORS = array( 'in', 'not in', '!=', 'isnot', '<>', 'contains' );

	/**
	 * Search_Criteria_Operator constructor.
	 *
	 * @param string $value
	 */
	public function __construct( $value = '' ) {

		$this->valid_values = array_unique( array_merge( self::$SCALAR_OPERATORS, self::$NUMERIC_OPERATORS, self::$ARRAY_OPERATORS ) );

		parent::__construct( $value );
	}

}