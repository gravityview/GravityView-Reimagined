<?php
namespace GV\Template;
use GV;
use GV\Template;

/**
 * Class GV_Template_Zone
 * @todo HELP!
 */
abstract class Zone extends \RecursiveArrayIterator {

	public $template;
	private $key = '';
	private $title = '';

	function __construct( Template $template, array $fields ) {

		$this->template = $template;

		parent::__construct( $fields, 2 );
	}

	public function set_key( $key ) {
		$this->key = $key;
	}

	public function set_title( $title ) {
		$this->title = $title;
	}

	public function render() {

		/** @var \GV\Template\Field $field */
		foreach( $fields as $field ) {

			$field->render();

		}
	}

}