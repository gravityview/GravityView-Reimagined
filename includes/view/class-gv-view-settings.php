<?php

/**
 * Holds the settings for a View
 */
class GV_View_Settings {

	/**
	 * @var GV_View
	 */
	var $view;

	/**
	 * @var array
	 */
	var $settings;

	function __construct( GV_View &$GV_View ) {

		$this->view = $GV_View;

		$this->settings = $this->get_settings();
	}

	function get_form() {
		return GVCommon::get_meta_form_id( $GV_View->id );
	}

	function get_template_id() {
		return GVCommon::get_meta_template_id( $GV_View->id );
	}

	function get_settings() {
		$this->settings = !empty( $this->settings ) ? $this->settings : GVCommon::get_template_settings( $this->view->post->id );
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