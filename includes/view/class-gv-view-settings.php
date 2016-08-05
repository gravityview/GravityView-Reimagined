<?php
namespace GV;
use GV;

/**
 * Holds the settings for a View
 */
final class View_Settings extends \ArrayObject {

	/**
	 * @var View
	 */
	var $view;

	function __construct( View &$GV_View, $atts = array() ) {

		$this->view = $GV_View;

		parent::__construct( $this->parse_settings( $atts ), 2 );
	}

	/**
	 * Alias of View::get_form_id()
	 * 
	 * @return false|string
	 */
	function get_form_id() {
		return $this->view->get_form_id();
	}

	/**
	 * @uses  GravityView_View_Data::get_default_args()
	 * @return array
	 */
	private function get_default_settings() {
		return \GravityView_View_Data::get_default_args();
	}

	/**
	 * Set the settings for a View
	 *
	 * @param  array $atts Custom settings to override default View settings
	 * @return array          Associative array of settings with plugin defaults used if not set by the View
	 */
	private function parse_settings( $atts = array() ) {

		$post_settings = get_post_meta( $this->view->ID, '_gravityview_template_settings', true );

		$defaults = $this->get_default_settings();

		$post_settings = wp_parse_args( (array)$post_settings, $defaults );

		$final_settings = wp_parse_args( $atts, $post_settings );

		$final_settings['id'] = $this->view->ID;

		return $final_settings;
	}

	/**
	 * Get the settings for the current View
	 * @return array View settings
	 */
	function get_settings() {
		return $this->getArrayCopy();
	}

	/**
	 *
	 * @param string $key Key to the setting requested
	 *
	 * @return mixed|false The value at the specified index or false.
	 */
	function get( $key ) {
		return $this->offsetGet( $key );
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return void
	 */
	function set( $key, $value ) {
		$this->offsetSet( $key, $value );
	}
}