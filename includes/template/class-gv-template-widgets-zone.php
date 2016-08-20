<?php
namespace GV\Template;
use GV\Template;

class Widgets_Zone extends Zone {

	function __construct( Template $template, array $widgets ) {

		foreach ( $widgets as $key => $widget ) {
			$widgets["{$key}"] = new Widget( $widget );
		}

		parent::__construct( $template, $widgets );
	}
}