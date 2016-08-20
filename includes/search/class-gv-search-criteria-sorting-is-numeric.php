<?php
namespace GV;

class Search_Criteria_Sorting_Is_Numeric extends Search_Parameter {
	protected $value = true;

	protected $valid_values = array( true, false );
}