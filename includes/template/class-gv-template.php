<?php

/**
 * Handle outputting the View
 * @todo HELP!
 */
class GV_Template( GV_View_Settings $GV_View_Settings ) {

	/**
	 * @var GV_Template_Zone[]
	 */
	private $zones = array();

	function __construct() {

	}

	function render() {
		foreach( $this->zones as $zone ) {
			$zone->render();
		}
	}

}

/**
 * Class GV_Template_Zone
 * @todo HELP!
 */
class GV_Template_Zone {

	/**
	 * @var GV_Template_Field[]
	 */
	var $fields;

	public function render() {

		foreach( $fields as $field ) {

			$field->render();

		}
	}

}

/**
 * Class GV_Template_Field
 * @todo HELP!
 */
class GV_Template_Field {

	/**
	 * @var GF_Field
	 */
	var $field;

	public function render() {

	}

	private function get_field_label( $force_frontend_label, $value ) {

	}

	private function get_field_content() {
		$field->get_field_content();
	}

}
