<?php

/**
 * Search Configuration for View
 *
 * @see GFAPI::get_entries()
 */
class GV_View_Search_Criteria {

	/**
	 * @var GV_View
	 */
	private $View;

	/**
	 * Entry status, ie: `active`
	 *
	 * @var string
	 */
	var $status = 'active';

	var $start_date = NULL;

	var $end_date = NULL;

	var $field_filters = array();

	private static $SCALAR_OPERATORS = array( 'is', '=', 'isnot', '<>', 'contains', 'starts_with', 'ends_with' );

	private static $NUMERIC_OPERATORS = array( 'greater_than', '>', 'less_than', '<' );

	private static $ARRAY_OPERATORS = array( 'in', 'not in', '!=', 'isnot', '<>', 'contains');

	/**
	 * Search mode All or any
	 *
	 * @var string
	 */
	var $mode = 'any';

	/**
	 * Sorting rules for search
	 * @var array
	 */
	var $sorting = array(
		'key'        => 'id',
		'direction'  => 'DESC',
		'is_numeric' => true,
	);

	public function __construct( GV_View $GV_View ) {
		$this->View = $GV_View;

		/**
		 * TODO: build search!
		 * - From default,
		 * - maybe overridden by advanced filter
		 * - maybe overridden by user request,
		 * - maybe overridden by advanced filter
		 */
	}

	/**
	 * @param array $filter
	 */
	public function add_filter( $filter ) {

		if ( ! isset( $filter['value'] ) ) {
			return;
		}

		$filter['operator'] = $this->validate_filter_operator( $filter );

		$this->field_filters[] = $filter;
	}

	/**
	 * @param $filter
	 *
	 * @return string|null If valid operator is passed, use it. Otherwise, return NULL
	 */
	private function validate_filter_operator( $filter ) {

		if ( ! isset( $filter['operator'] ) ) {
			return NULL;
		}

		if (
			in_array( $operator, self::$SCALAR_OPERATORS ) ||
			in_array( $operator, self::$NUMERIC_OPERATORS ) ||
			in_array( $operator, self::$ARRAY_OPERATORS )
		) {
			return $operator;
		}

		return NULL;
	}

	/**
	 * @param string $status
	 */
	public function set_status( $status ) {
		$this->status = $status;
	}

	/**
	 * @param null $start_date
	 */
	public function set_start_date( $start_date ) {
		$this->start_date = $start_date;
	}

	/**
	 * @param null $end_date
	 */
	public function set_end_date( $end_date ) {
		$this->end_date = $end_date;
	}

	public function set_sorting( $key, $direction, $is_numeric = true ) {
		$this->sorting['key']        = $key;
		$this->sorting['direction']  = $direction;
		$this->sorting['is_numeric'] = $is_numeric;
	}

	public function set_paging( $offset, $page_size ) {
		$this->sorting['offset']    = $offset;
		$this->sorting['page_size'] = $page_size;
	}

	public function set_mode( $all_any ) {
		if ( $all_any === 'any' ) {
			$this->mode = 'any';
		} else {
			$this->mode = 'all';
		}

		$this->field_filters['mode'] = $this->mode;
	}
}
