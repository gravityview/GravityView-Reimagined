<?php
namespace GV;

use GravityView_Widget;

class Template_Widget extends Template_Item {

	protected $item_type = 'widget';

	/**
	 * @var GravityView_Widget
	 */
	var $gravityview_widget;

	/**
	 * Pull in existing GravityView classes to handle widget output
	 */
	function setup() {
		$widget_id = $this->offsetGet( 'id' );

		$widget_id = ucwords( $widget_id, '_' );

		$class_name = sprintf( '\GravityView_Widget_%s', $widget_id );

		if ( class_exists( $class_name ) ) {
			$this->gravityview_widget = new $class_name();
		}
	}

	/**
	 * Render a GravityView widget using the \GV\Template_Widget settings
	 *
	 * @see GravityView_Widget::render_frontend()
	 */
	function render() {

		$this->setup();

		// Widget not found
		if ( ! $this->gravityview_widget ) {
			// TODO: Exception
			return;
		}

		$widget_settings = $this->getArrayCopy();

		/** @var GravityView_Widget */
		$this->gravityview_widget->render_frontend( $widget_settings );
	}

}