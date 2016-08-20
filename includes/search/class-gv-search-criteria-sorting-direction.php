<?php
namespace GV;

class Search_Criteria_Sorting_Direction extends Search_Parameter {

	protected $value = 'DESC';

	protected $valid_values = array( 'ASC', 'DESC', 'RAND' );

}