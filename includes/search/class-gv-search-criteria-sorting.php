<?php
namespace GV;

class Search_Criteria_Sorting extends Search_Parameter_Collection {

	/**
	 * @var Search_Criteria_Sorting_Key
	 */
	protected $key;

	/**
	 * @var Search_Criteria_Sorting_Direction
	 */
	protected $direction;

	/**
	 * @var Search_Criteria_Sorting_Is_Numeric
	 */
	protected $is_numeric;

	protected static $defaults = array(
		'key'        => 'id',
		'direction'  => 'DESC',
		'is_numeric' => true,
	);

}