<?php
namespace GV;

class Search_Criteria_Paging extends Search_Parameter_Collection {

	protected $offset;

	protected $page_size;

	protected static $defaults = array(
		'offset'    => 0,
		'page_size' => 20,
	);
}