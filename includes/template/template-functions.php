<?php
/**
 * Template-specific functions
 */

function gravityview_get_widgets( $view_id, $context = 'directory' ) {
	return (array) get_post_meta( $view_id, sprintf( '_gravityview_%s_widgets', $context ), true );
}