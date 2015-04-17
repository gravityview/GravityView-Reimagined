<?php

/**
 * Handle outputting the View
 * @todo HELP!
 *
 */
class GV_Template {

	/**
	 * @var GV_View
	 */
	var $View;

	/**
	 * @var GV_Template_Zone[]
	 */
	private $zones = array();

	private $template_id;

	/**
	 * @param GV_View $GV_View
	 */
	function __construct( $GV_View ) {

		$this->View = $GV_View;

		$this->set_template_id();

		$this->set_zones();
	}

	function set_template_id() {
		$this->template_id = GVCommon::get_meta_template_id( $this->View->ID );
	}

	/**
	 * Set the field configuration for the View
	 *
	 */
	function set_zones() {
		$this->zones = GVCommon::get_directory_fields( $this->View->ID );
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
