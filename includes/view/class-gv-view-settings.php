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

		$this->set_settings();
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
	 * @param  int $post_id View ID
	 * @return array          Associative array of settings with plugin defaults used if not set by the View
	 */
	private function set_settings() {

		$post_settings = get_post_meta( $this->View->ID, '_gravityview_template_settings', true );

		$defaults = $this->get_default_settings();

		$this->settings = wp_parse_args( (array)$post_settings, $defaults );
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