<?php
namespace GV\Template;
use GV\Template;

class Context extends \RecursiveArrayIterator {

	/**
	 * @var Template
	 */
	private $template;

	/** @var string slug for the context */
	var $key = '';

	var $widgets = array();

	/**
	 * Template_Context constructor.
	 *
	 * @param Template $template
	 * @param string $key
	 */
	public function __construct( $template, $key, $fields = array() ) {
		$this->template = $template;
		$this->key = $key;

		$this->get_widgets();

		parent::__construct( $fields, 2 );
	}


	/**
	 * TODO: What do we do when we want to convert to more flexible "rows" instead? Perhaps the "$zone" would be just the (int) row ID?
	 */
	function setup_widgets() {
		$widget_zones = gravityview_get_widgets( $this->template->view->get_id(), $this->key );

		foreach ( $widget_zones as $key => $widget_zone ) {

			if( empty( $key ) ) { continue; }

			/// "header_left" => 'header', 'left'
			list( $location, $zone ) = array_pad( explode( '_', $key ), 2, '' );

			$this->widgets[ $location ][ $zone ] = new Widgets_Zone( $this->template, $widget_zone );
			//Template_Widget( $widget_zone );
		}
	}

	function get_widgets( $widget_location = '' ) {

		// Only set them up once
		if( empty( $this->widgets ) ) {
			$this->setup_widgets();
		}

		if( ! empty( $widget_location ) ) {
			return (array) rgar( $this->widgets, $widget_location );
		}

		return $this->widgets;
	}
}
