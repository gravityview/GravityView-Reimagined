<?php
namespace GV;

class Search_Criteria_Date_Range extends Search_Parameter {

	/**
	 * @var Search_Criteria_Date
	 */
	var $start;

	/**
	 * @var Search_Criteria_Date
	 */
	var $end;

	/**
	 * Search_Criteria_Date_Range constructor.
	 */
	public function __construct( $start_date, $end_date ) {

		$this->start = new Search_Criteria_Date( $start_date );

		$this->end = new Search_Criteria_Date( $end_date );

		parent::__construct();
	}

	/**
	 * TODO: Proper errors
	 *
	 * @return bool
	 */
	protected function is_valid() {

		$valid_dates = $this->start->is_valid() && $this->end->is_valid();

		if( ! $valid_dates ) {
			return false;
		}

		$valid_range = $this->start->timestamp < $this->end->timestamp;

		if( ! $valid_range ) {
			return false;
		}

		return true;
	}
}