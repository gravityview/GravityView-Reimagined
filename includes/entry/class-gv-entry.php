<?php

/**
 * Class GV_Entry
 *
 * @todo Move GVCommon::get_entry()
 */
class GV_Entry {

	/**
	 * The entry ID
	 * @var int
	 */
	public $id;

	/**
	 * The entry slug. May be the same as the $id
	 * @var id|string
	 */
	var $slug;

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
			$this->entry = $id_slug_or_array;
		} else {
			$this->entry = GVCommon::get_entry( $id, true );
		}

		$this->form = GV_Forms::get_instance()->get( $this->entry['form_id'] );

	}

	function get_meta() {
		return GVCommon::get_entry_meta( $this->id );
	}

	/**
	 * @return GV_Form
	 */
	function get_form() {
		return $this->form;
	}

	function get_id() {
		return $this->id;
	}

}