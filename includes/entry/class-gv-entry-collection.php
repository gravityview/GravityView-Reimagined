<?php
namespace GV;

/**
 * Hold the entries for a View
 */
final class Entry_Collection extends \ArrayIterator {


	/**
	 * @param array $gf_entries Array of entries
	 */
	function __construct( array $gf_entries ) {

		$entries = array();

		foreach( $gf_entries as $entry ) {
			$entries[] = new Entry( $entry );
		}

		parent::__construct( $entries );
	}

	function add( $entry ) {

		if( is_array( $entry ) ) {
			$entry = new Entry( $entry );
		}

		$this->offsetSet( $entry->get_slug(), $entry );
	}

	/**
	 * Remove an entry
	 *
	 * @param string|int $id Slug or ID of entry
	 *
	 * @return void
	 */
	function remove( $id ) {
		$this->offsetUnset( $id );
	}

	/**
	 * Get an entry by slug or ID
	 * @param string|int $id
	 *
	 * @return Entry|false If found, get the entry at ID $id. Otherwise, return false.
	 */
	function get( $id ) {

		if ( $this->offsetExists( $id ) ) {
			return $this->offsetGet( $id );
		}

		return false;
	}

	/**
	 * Get the current count of the number of entries in the collection
	 * @return int
	 */
	function count() {
		return parent::count();
	}

}