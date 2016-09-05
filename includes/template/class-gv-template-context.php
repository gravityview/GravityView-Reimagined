<?php
namespace GV;

class Template_Context extends \RecursiveArrayIterator {

	/**
	 * @var Template
	 */
	private $template;

	/** @var string slug for the context */
	private $key = '';

	private $widgets = array();

	/**
	 * Template_Context constructor.
	 *
	 * @param Template $template
	 * @param string $key
	 */
	public function __construct( $template, $key, $fields = array() ) {
		$this->template = $template;
		$this->key = $key;

		$this->setup_widgets();

		parent::__construct( $fields, 2 );
	}


	/**
	 * TODO: What do we do when we want to convert to more flexible "rows" instead? Perhaps the "$zone" would be just the (int) row ID?
	 */
	function setup_widgets() {

		// Only set them up once
		if( ! empty( $this->widgets ) ) {
			return;
		}

		$widget_zones = gravityview_get_widgets( $this->template->view->get_id(), $this->key );

		foreach ( $widget_zones as $key => $widget_zone ) {

			if( empty( $key ) ) { continue; }

			/// "header_left" => 'header', 'left'
			list( $location, $zone ) = array_pad( explode( '_', $key ), 2, '' );

			$this->widgets[ $location ][ $zone ] = new Template_Widgets_Zone( $this->template, $widget_zone );
		}
	}

	/**
	 * @return Template_Widgets_Zone[]
	 */
	function get_widget_zones() {

		$this->setup_widgets();

		return $this->widgets;
	}

	/**
	 * Get an array of zones in a location
	 *
	 * For example: [ 'right' => Template_Widgets_Zone[], 'top' => Template_Widgets_Zone[] ]
	 *
	 * @param string $widget_location Widget location ('header', 'footer')
	 *
	 * @return array
	 */
	function get_widget_location( $widget_location ) {
		return rgar( $this->get_widget_zones(), $widget_location, array() );
	}

	/**
	 * Get the widgets in a location at a specific zone
	 *
	 * @param string $widget_location "header" or "footer"
	 * @param string $widget_zone "top" or "right" or "left"
	 *
	 * @return array
	 */
	function get_widget_zone( $widget_location, $widget_zone ) {
		return (array) rgars( $this->get_widget_zones(), "$widget_location/$widget_zone" );
	}

	/**
	 * Get all widgets in the current Context's widget zones
	 *
	 * @return array
	 */
	function get_widgets() {

		$widget_zones = $this->get_widget_zones();

		$widgets = array();

		/** @var Template_Widgets_Zone $widget_zone */
		foreach ( $widget_zones as $widget_locations ) {

			foreach ( $widget_locations as $widget_zone ) {
				$widgets = array_merge( $widgets, $widget_zone->getArrayCopy() );
			}
		}

		return $widgets;
	}

	/**
	 * Get all widgets in the current Contect by widget type
	 *
	 * @param string $widget_type_id Type of widget, like `search_bar` or `page_links`
	 *
	 * @return Template_Widget[]
	 */
	function get_widgets_by_type( $type = '' ) {

		$widgets = $this->get_widgets();

		return wp_list_filter( $widgets, array( 'id' => $type ) );
	}
}
