<?php
namespace GV;

use ArrayIterator;

class Search_Criteria_Filter_Collection extends ArrayIterator {

	/**
	 * @param array|Search_Criteria_Filter $filter
	 */
	public function add( $filter ) {
		$this->append( new Search_Criteria_Filter( $filter ) );
	}

	public function to_array() {
		return $this->getArrayCopy();
	}

	public function getArrayCopy() {
		$filters = parent::getArrayCopy();

		/** @var Search_Criteria_Filter $filter */
		foreach ( $filters as &$filter ) {
			$filter = $filter->to_array();
		}

		return $filters;
	}

}