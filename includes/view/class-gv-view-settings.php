<?php

/**
 * Holds the settings for a View
 */
class GV_View_Settings {

	var $view;

	var $settings;

	function __construct( GV_View $GV_View ) {

		$this->view = $GV_View;

	}

	function get_form() {
		return GVCommon::get_meta_form_id( $GV_View->id );
	}

	function get_template_id() {
		return GVCommon::get_meta_template_id( $GV_View->id );
	}

	/**
	 *
	 * @param string $key Key to the setting requested
	 *
	 * @return mixed|bool Setting value; False if not exists.
	 */
	function get_setting( $key ) {
		return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : false;
	}
}