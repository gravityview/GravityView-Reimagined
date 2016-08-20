<?php
namespace GV\Template;
use GV\Template;

class Field extends Item {

	var $zone;

	var $field;

	/**
	 * Field constructor.
	 */
	public function __construct( Zone $zone, array $array ) {

		$this->zone = $zone;
		
		parent::__construct( $array, 2 );
	}

	/**
	 * @return \GF_Field
	 */
	function get_gf_field() {
		return \GFFormsModel::get_field( $this->zone->template->view->get_form(), $this->offsetGet('id') );
	}

}
