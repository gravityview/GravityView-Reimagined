<?php
namespace GV;

class Template_Fields_Zone extends Template_Zone {

	function __construct( Template $template, array $fields ) {

		$this->template = $template;

		foreach ( $fields as $key => $field ) {
			$fields["{$key}"] = new Template_Field( $this, $field );
		}

		parent::__construct( $template, $fields );
	}
}