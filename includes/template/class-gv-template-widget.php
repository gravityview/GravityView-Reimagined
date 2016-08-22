<?php
namespace GV;

use GravityView_frontend;

class Template_Widget extends Template_Item {

	protected $item_type = 'widget';

	var $gravityview_widget;

	function setup() {
		$widget_id = $this->offsetGet( 'id' );

		$widget_id = ucwords( $widget_id, '_' );

		$class_name = sprintf( '\GravityView_Widget_%s', $widget_id );

		if ( class_exists( $class_name ) ) {
			$this->gravityview_widget = new $class_name();
		}
	}

	function render() {

		$this->setup();

		if ( $this->gravityview_widget ) {
			
			$widget_settings = $this->getArrayCopy();
			
			/** @var \GravityView_Widget */
			$this->gravityview_widget->render_frontend( $widget_settings );
		}

	}

}