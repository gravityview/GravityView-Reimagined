<?php
namespace GV;

class Template_Widgets_Zone extends Template_Zone {

	function __construct( Template &$template, array $widgets ) {

		foreach ( $widgets as $key => $widget ) {
			$widgets["{$key}"] = new Template_Widget( $widget );
		}

		parent::__construct( $template, $widgets );
	}
}