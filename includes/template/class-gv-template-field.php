<?php
namespace GV;

class Template_Field extends Template_Item {

	protected $item_type = 'field';

	// TODO: Implement this to make way for future multiple form IDs
	var $form_id;

	var $zone;

	var $field;

	/**
	 * Field constructor.
	 */
	public function __construct( Template_Zone $zone, array $array ) {

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
