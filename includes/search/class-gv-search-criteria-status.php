<?php
namespace GV;

class Search_Criteria_Status extends Search_Parameter {

	protected $value = 'active';

	protected $valid_values = array( 'active', 'trash', 'spam' );

}