<?php
namespace GV;

use GFAPI;

class Search {

	/**
	 * @var int|int[]
	 */
	private $form_ids;

	/**
	 * @var Search_Criteria
	 */
	private $search_criteria;

	/**
	 * @var Entry_Collection
	 */
	private $entry_collection;

	/**
	 * Search constructor.
	 *
	 * @param int|int[] $form_ids
	 * @param array|Search_Criteria $search_criteria
	 */
	function __construct( $form_ids = 0, $search_criteria = array() ) {

		$this->set_form_ids( $form_ids );
		$this->set_search_criteria( $search_criteria );

		if( ! isset( $this->form_ids ) ) {
			// TODO Exception
			return;
		}
	}

	/**
	 * @param int|int[] $form_ids
	 */
	private function set_form_ids( $form_ids ) {

		if ( ! is_numeric( $form_ids ) ) {
			return;
		}

		if( is_array( $form_ids ) ) {
			$numbers = array_filter( $form_ids, 'is_int' );

			if ( empty( $numbers ) ) {
				return;
			}

			$form_ids = array_map( 'intval', $form_ids );
		} else {
			$form_ids = intval( $form_ids );
		}

		$this->form_ids = $form_ids;
	}

	/**
	 * @param $search_criteria
	 */
	private function set_search_criteria( $search_criteria = array() ) {
		$this->search_criteria = new Search_Criteria( $search_criteria );
	}

	/**
	 * @return Search_Criteria
	 */
	public function get_search_criteria() {
		return $this->search_criteria;
	}

	/**
	 * Perform the query via GFAPI
	 *
	 * @uses GFAPI::get_entries()
	 */
	private function fetch() {

		$entries = GFAPI::get_entries( $this->form_ids, $this->search_criteria );

		$this->entry_collection = new Entry_Collection( $entries );
	}

	/**
	 * Refresh the search results
	 *
	 * You may want to call this after adding search criteria parameters
	 *
	 * @return void
	 */
	public function refresh() {
		$this->fetch();
	}

	/**
	 * Get entries for a given search
	 *
	 * @return Entry_Collection (by reference)
	 */
	function &get_entries() {

		if( ! isset( $this->entry_collection ) ) {
			$this->fetch();
		}

		return $this->entry_collection;
	}

}