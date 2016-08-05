<?php
namespace GV;
use GV;

/**
 * Store page meta from the requested page
 */
final class Page_Meta {

	/**
	 * Post ID. Here for easy access
	 * @var int
	 */
	private $ID = 0;

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
	 * @var Page_Meta
	 */
	private static $instance;

	/**
	 * @return Page_Meta
	 */
	public static function get_instance( Mission_Control $GV_Mission_Control ) {

		if( empty( self::$instance ) ) {
			self::$instance = new self( $GV_Mission_Control );
		}

		return self::$instance;
	}

	/**
	 * Add hooks
	 */
	private function __construct( Mission_Control $GV_Mission_Control ) {
		$this->add_hooks();
	}

	private function add_hooks() {
		add_action( 'wp', array( $this, 'setup_vars' ), 20 );
	}

	public function setup_vars() {
		global $post;

		do_action( 'gravityview/page_meta/setup_vars/before', $this );

		$this->ID = $post->ID;
		$this->set_title( $post->post_title );
		$this->set_description( $post->post_excerpt );
		$this->set_canonical( get_permalink( $post->ID ) );

		do_action( 'gravityview/page_meta/setup_vars/after', $this );
	}

	/**
	 * @return string
	 */
	public function get_title() {
		return apply_filters( 'gravityview/page_meta/get_title', $this->title );
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
		return apply_filters( 'gravityview/page_meta/get_description', $this->description );
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
		return apply_filters( 'gravityview/page_meta/get_canonical', $this->canonical );
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
		return apply_filters( 'gravityview/page_meta/get_image', $this->image );
	}

	/**
	 * @param string $image
	 */
	public function set_image( $image ) {
		$this->image = $image;
	}

}