<?php
namespace GV;

class Search_Criteria_Filter extends Search_Parameter_Collection {

	/**
	 * @var Search_Criteria_Filter_Key
	 */
	protected $key;

	/**
	 * @var Search_Criteria_Filter_Value
	 */
	protected $value;

	/**
	 * @var Search_Criteria_Filter_Operator
	 */
	protected $operator;

	protected static $defaults = array(
		'key'      => NULL,
		'value'    => '',
		'operator' => 'contains',
	);

}