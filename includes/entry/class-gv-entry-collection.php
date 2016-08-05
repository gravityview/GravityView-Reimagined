<?php
namespace GV;
use GV;

/**
 * Hold the entries for a View
 */
final class Entry_Collection extends \ArrayIterator {

	/**
	 * @var GV_Entry[] Array of GV_Entry objects
	 */
	private $entries = array();

	/**
	 * @param array $gf_entries Array of entries
	 */
	function __construct( array $gf_entries ) {
		foreach( $gf_entries as $entry ) {
			$entries[] = new Entry( $entry );
		}
	}

	function add( GV_Entry $GV_Entry ) {
		$this->entries[ $GV_Entry->get_id() ] = $GV_Entry;
	}

	/**
	 * Remove an entry
	 *
	 * @param string|int $id Slug or ID of entry
	 *
	 * @return boolean True: entry removed; False: entry not found to remove.
	 */
	function remove( $id ) {
		if( isset( $this->entries[ $id ] ) ) {
			unset( $this->entries[ $id ] );
			return true;
		}
		return false;
	}

	/**
	 * Get an entry by slug or ID
	 * @param string|int $id
	 *
	 * @return Entry|false If found, get the entry at ID $id. Otherwise, return false.
	 */
	function get( $id ) {
		if( isset( $this->entries[ $id ] ) ) {
			return $this->entries[ $id ];
		}

		return false;
	}

	/**
	 * Get the current count of the number of entries in the collection
	 * @return int
	 */
	function count() {
		return sizeof( $this->entries );
	}

}