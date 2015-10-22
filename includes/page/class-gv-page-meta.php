<?php

/**
 * Store current page meta
 */
class GV_Page_Meta {

	/**
	 * Page Title <title> tag value
	 * @var string
	 */
	private $title = '';

	/**
	 * Page Description <meta name="description"> tag value
	 * @var string
	 */
	private $description = '';

	/**
	 * Page URL <link rel="canonical"> value
	 * @var string
	 */
	private $canonical = '';

	/**
	 * OpenGraph image URL for the page
	 * @var string
	 */
	private $image = '';


	/**
	 * @var GV_Page_Meta
	 */
	private static $instance;

	/**
	 * @return GV_Page_Meta
	 */
	public static function get_instance( GV_Mission_Control $GV_Mission_Control ) {

		if( empty( self::$instance ) ) {
			self::$instance = new self( $GV_Mission_Control );
		}

		return self::$instance;
	}

	/**
	 * Add hooks
	 */
	private function __construct( GV_Mission_Control $GV_Mission_Control ) {

	}

	/**
	 * @return string
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function set_title( $title ) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function set_description( $description ) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function get_canonical() {
		return $this->canonical;
	}

	/**
	 * @param string $canonical
	 */
	public function set_canonical( $canonical ) {
		$this->canonical = $canonical;
	}

	/**
	 * @return string
	 */
	public function get_image() {
		return $this->image;
	}

	/**
	 * @param string $image
	 */
	public function set_image( $image ) {
		$this->image = $image;
	}

}