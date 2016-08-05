<?php
namespace GV;
use GV;

/**
 * Class Entry
 *
 */
final class Entry extends \ArrayObject {

	/**
	 * The entry ID
	 * @var_dump int
	 */
	public $ID;

	/**
	 * The entry slug. May be the same as the $id
	 * @var int|string
	 */
	var $slug;

	/**
	 * @type array Hold the original Gravity Forms entry array
	 */
	var $entry;

	/**
	 * @var GV_Form
	 */
	var $form;

	/**
	 *
	 * @param $id_slug_or_array
	 */
	function __construct( $id_slug_or_array ) {

		if( is_array( $id_slug_or_array ) ) {
			$entry = $id_slug_or_array;
		} else {
			$entry = GVCommon::get_entry( $id_slug_or_array, true );
		}

		$this->entry = $entry;

		$this->form = gravityview()->forms->get( $this->entry['form_id'] );

	}

	function get_meta() {
		return GVCommon::get_entry_meta( $this->ID );
	}

	/**
	 * @return GV_Form
	 */
	function get_form() {
		return $this->form;
	}

	function get_id() {
		return $this->ID;
	}

}