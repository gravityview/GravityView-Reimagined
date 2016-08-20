<?php
namespace GV;

class Search_Criteria_Paging_Page_Size extends Search_Parameter {

	protected $value = 20;

	protected $valid_values = 'is_int';
}