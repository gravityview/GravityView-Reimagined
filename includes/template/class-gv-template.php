<?php
namespace GV;
use GV;

/**
 * Handle outputting the View
 * @todo HELP!
 *
 */
final class Template {

	/**
	 * @var View
	 */
	var $View;

	/**
	 * @var Template_Zone[]
	 */
	private $zones = array();

	/**
	 * @var string Template identifier
	 */
	private $template_slug;

	/**
	 * @param View $GV_View
	 */
	function __construct( $GV_View ) {

		$this->View = $GV_View;

		$this->set_template_slug();

		$this->set_zones();
	}

	function set_template_slug() {
		$this->template_slug = GVCommon::get_meta_template_id( $this->View->ID );
	}

	/**
	 * Set the field configuration for the View
	 *
	 */
	function set_zones() {
		$this->zones = \GVCommon::get_directory_fields( $this->view->ID );
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
class Template_Zone {

	/**
	 * @var Template_Field[]
	 */
	var $fields;

	public function render() {

		/** @var Template_Field $field */
		foreach( $fields as $field ) {

			$field->render();

		}
	}

}

/**
 * Class GV_Template_Field
 * @todo HELP!
 */
class Template_Field {

	/**
	 * @var \GF_Field
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
