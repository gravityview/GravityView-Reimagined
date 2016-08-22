<?php
namespace GV;

use \GVCommon;

/**
 * Handle outputting the View
 * @todo HELP!
 *
 */
final class Template {

	/**
	 * @var View
	 */
	var $view;

	/**
	 * @var Template_Context[]
	 */
	private $contexts = array();

	/**
	 * @var string Template identifier
	 */
	private $template_slug;

	/**
	 * @param View $GV_View
	 */
	public function __construct( View &$View ) {

		$this->view = &$View;

		$this->template_slug = $this->view->get_template_id();

	}

	/**
	 * @return array
	 */
	private function get_context_keys() {
		return (array) apply_filters( 'gravityview/template/contexts', array( 'directory', 'single', 'edit' ) );
	}

	private function setup_contexts() {

		$layout = $this->get_field_layout();

		$context_keys = $this->get_context_keys();

		/** @var string $context_key */
		foreach ( $context_keys as $context_key ) {
			$this->contexts[ $context_key ] = null; // Make sure it's set up when instantiating the Context
			$this->contexts[ $context_key ] = new Template_Context( $this, $context_key, rgar( $layout, $context_key, array() ) );
		}
	}

	/**
	 * Set the field configuration for the View
	 * Not called by default.
	 *
	 * @return array
	 */
	public function get_contexts() {

		if( empty( $this->contexts ) ) {
			$this->setup_contexts();
		}

		return $this->contexts;
	}

	/**
	 * @param $fields
	 *
	 * @return array
	 */
	private function get_field_layout() {
		$layout = array();

		$old_layout = GVCommon::get_directory_fields( $this->view->ID );

		foreach ( $old_layout as $context_id => $context_fields ) {

			// 'directory_list-title' => 'directory', 'list-title'
			list( $context, $template_slug_and_zone ) = explode( '_', $context_id );

			// 'list-title' => 'list', 'title'
			list( $template_slug, $zone ) = array_pad( explode( '-', $template_slug_and_zone ), 2, '' );

			if( ! empty( $zone ) ) {
				if( ! isset( $this->contexts["{$context}"][$zone] ) ) {
					$layout["{$context}"]["{$zone}"] = new Template_Fields_Zone( $this, $context_fields );
				}
			} else {
				$layout["{$context}"] = new Template_Fields_Zone( $this, $context_fields );
			}
		}

		return $layout;
	}

	public function render() {
		foreach( $this->zones as $zone ) {
			$zone->render();
		}
	}

}

// Each template has contexts
// Each context has zones
// Each zone has fields or widgets
// Each field or widget has settings


