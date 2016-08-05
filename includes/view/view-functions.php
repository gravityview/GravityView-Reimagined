<?php
/**
 * View-specific functions
 */

/**
 * Determines if a post, identified by the specified ID, exist
 * within the WordPress database.
 *
 * @see http://tommcfarlin.com/wordpress-post-exists-by-id/ Fastest check available
 * @param    int    $view_id    The ID of the post to check
 * @return   bool   True if the post exists; otherwise, false.
 */
function gravityview_view_exists( $view_id ) {
	return is_string( get_post_status( $view_id ) );
}