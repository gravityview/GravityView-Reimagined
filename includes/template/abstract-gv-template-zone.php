<?php
namespace GV;

/**
 * Class GV_Template_Zone
 * @todo HELP!
 */
abstract class Template_Zone extends \ArrayIterator {

	public $template;

	private $key = '';
	private $title = '';

	function __construct( Template $template, array $fields ) {

		$this->template = $template;

		parent::__construct( $fields, 2 );
	}

	public function get_key() {
		return $this->key;
	}

	public function set_key( $key ) {
		$this->key = $key;
	}

	public function set_title( $title ) {
		$this->title = $title;
	}

	public function render() {
		
		/** @var Template_Item $item */
		foreach( $this as $item ) {
			$item->render();
		}
	}

}