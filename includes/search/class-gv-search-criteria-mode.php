<?php
namespace GV;

class Search_Criteria_Mode extends Search_Parameter {

	protected $value = 'all';

	protected $valid_values = array( 'all', 'any' );

}