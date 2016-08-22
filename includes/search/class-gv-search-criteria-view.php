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

		parent::__construct();

		$this->view = & $View;

		$this->build_search( $search_criteria );
	}

	private function build_search( $search_criteria = array() ) {

		$this->start_date = new Search_Criteria_Start_Date( $this->view->get_setting( 'start_date' ) );
		$this->end_date = new Search_Criteria_End_Date( $this->view->get_setting( 'end_date' ) );

		$sort_field_id = $this->view->get_setting( 'sort_field' );

		$this->sorting->set( 'key', $sort_field_id );
		$this->sorting->set( 'direction', $this->view->get_setting( 'sort_direction' ) );
		$this->sorting->set( 'is_numeric', $this->view->get_form()->is_field_numeric( $sort_field_id ) );

		$this->paging->set( 'page_size', $this->view->get_setting( 'page_size' ) );

		// TODO: Page offset
	}
}