<?php
namespace GV\Template;
use GV\Template;

class Fields_Zone extends Zone {

	function __construct( Template $template, array $fields ) {

		$this->template = $template;

		foreach ( $fields as $key => $field ) {
			$fields["{$key}"] = new Field( $this, $field );
		}

		parent::__construct( $template, $fields );
	}
}