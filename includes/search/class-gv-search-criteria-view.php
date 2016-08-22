<?php
namespace GV;

/**
 * Search Configuration for View
 *
 * @see GFAPI::get_entries()
 */
final class Search_Criteria_View extends Search_Criteria {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Search_Criteria_View constructor.
	 *
	 * @param View $view
	 */
	public function __construct( View &$View, $search_criteria = array() ) {

		$this->view = &$View;

		$criteria = $this->build_search( $search_criteria );

		parent::__construct( $criteria );
	}

	private function build_search( $search_criteria = array() ) {
		
	}
}