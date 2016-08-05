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
	var $View;

	/**
	 * @var array
	 */
	var $settings;

	function __construct( View &$GV_View, $atts = array() ) {

		$this->View = $GV_View;

		parent::__construct( $this->parse_settings( $atts ), 2 );
	}

	function get_form_id() {
		return GVCommon::get_meta_form_id( $this->View->ID );
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

		if( empty( $this->settings ) ) {
			$this->set_settings();
		}

		return $this->settings;
	}

	/**
	 *
	 * @param string $key Key to the setting requested
	 *
	 * @return mixed|bool Setting value; False if not exists.
	 */
	function get( $key ) {
		return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : false;
	}
}