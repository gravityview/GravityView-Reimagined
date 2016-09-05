<?php
namespace GV;

use ArrayObject;


/**
 * Search Configuration for View
 *
 * @see GFAPI::get_entries()
 */
class Search_Criteria extends ArrayObject {

	/**
	 * Entry status, ie: `active`
	 *
	 * @var Search_Criteria_Status
	 */
	var $status;

	/**
	 * @var Search_Criteria_Start_Date
	 */
	var $start_date;

	/**
	 * @var Search_Criteria_End_Date
	 */
	var $end_date;

	/**
	 * @var Search_Criteria_Filter_Collection
	 */
	var $field_filters;

	/**
	 * Search mode All or any
	 *
	 * @var Search_Criteria_Mode
	 */
	var $mode;

	/**
	 * Sorting rules for search
	 * @var Search_Criteria_Sorting
	 */
	var $sorting;

	/**
	 * Paging rules for search
	 * @var Search_Criteria_Paging
	 */
	var $paging;

	/**
	 * TODO: build search!
	 * - From default,
	 * - maybe overridden by advanced filter
	 * - maybe overridden by user request,
	 * - maybe overridden by advanced filter
	 */

	/**
	 * Search_Criteria constructor.
	 *
	 * @param array|object $input The input parameter accepts an array or an Object.
	 * @param int $flags
	 */
	public function __construct( $input = array(), $flags = 2 ) {

		$this->sorting = new Search_Criteria_Sorting( rgar( $input, 'sorting' ) );
		$this->paging = new Search_Criteria_Paging( rgar( $input, 'paging' ) );
		$this->status = new Search_Criteria_Status( rgar( $input, 'status' ) );
		$this->mode = new Search_Criteria_Mode( rgar( $input, 'mode' ) );
		$this->start_date = new Search_Criteria_Start_Date( rgar( $input, 'start_date' ) );
		$this->end_date = new Search_Criteria_End_Date( rgar( $input, 'end_date' ) );
		$this->field_filters = new Search_Criteria_Filter_Collection();

		if( $filters = rgar( $input, 'field_filters' ) ) {
			foreach ( $filters as $filter ) {
				$this->field_filters->add( $filter );
			}
		}
	}


	/**
	 * @param array|Search_Criteria_Filter $filter
	 */
	public function add_filter( $filter ) {
		$this->field_filters->add( $filter );
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
		$this->sorting->set( 'key', $key );
		$this->sorting->set( 'direction', $direction );
		$this->sorting->set( 'is_numeric', $is_numeric );
	}

	public function set_paging( $offset = 0, $page_size = 20 ) {
		$this->paging->set( 'offset', $offset );
		$this->paging->set( 'page_size', $page_size );
	}

	public function set_mode( $all_any = 'any' ) {

		$this->mode = new Search_Criteria_Mode( $all_any );

		$this->field_filters['mode'] = $this->mode->get();
	}

	/**
	 * @param bool $include_sorting_and_paging Include `sorting` and `paging` keys?
	 *
	 * @return array
	 */
	public function getArrayCopy( $include_sorting_and_paging = true ) {

		$return = array(
			'status' => $this->status->get(),
			'mode' => $this->mode->get(),
			'start_date' => $this->start_date->get(),
			'end_date' => $this->end_date->get(),
			'field_filters' => $this->field_filters->to_array(),
		);

		if( $include_sorting_and_paging ) {
			$return['sorting'] = $this->sorting->to_array();
			$return['paging'] = $this->paging->to_array();
		}

		return $return;
	}

	/**
	 * Get only the values used by GFAPI::get_entries()' $search_criteria parameter
	 *
	 * @return array
	 */
	public function get_search_criteria() {
		return $this->getArrayCopy( false );
	}

	public function to_array( $include_all = true ) {
		return $this->getArrayCopy( $include_all );
	}
}