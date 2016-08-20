<?php
namespace GV\Template;
use GV\Template;

/**
 * Class GV_Template_Field
 * @todo HELP!
 */
abstract class Item extends \ArrayObject {

	private $label = '';

	private $show_label = 0;

	private $custom_label = '';

	private $custom_class = '';

	public function render() {}

	/**
	 * @param $index
	 *
	 * @return mixed
	 */
	private function get( $index ) {
		return $this->offsetGet( $index );
	}

	/**
	 * Does this item have a visibility cap?
	 * @return bool|mixed
	 */
	public function visibility_cap() {
		$cap = false;

		$only_loggedin = $this->get('only_loggedin');

		if ( ! empty( $only_loggedin ) ) {
			$cap = $this->get( 'only_loggedin_cap' );
		}

		return $cap;
	}

	/**
	 * @param $force_frontend_label
	 * @param $value
	 *
	 * @return string The label
	 */
	public function get_label( $force_frontend_label, $value ) {
		return apply_filters( 'gravityview/template/item/get_label', $this->get( 'label' ), $this );
	}

	/**
	 * Whether to show the label
	 * @return bool
	 */
	function show_label() {
		return (bool) apply_filters( 'gravityview/template/item/show_label', $this->get( 'show_label' ), $this );
	}

}
