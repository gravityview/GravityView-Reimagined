<?php
/**
 * General helper functions
 */

if( ! function_exists( 'has_shortcode_r' ) ) {
	/**
	 * Placeholder until the recursive has_shortcode() patch is merged
	 *
	 * @see https://core.trac.wordpress.org/ticket/26343#comment:10
	 *
	 * @param string $content Content to check whether there's a shortcode
	 * @param string $tag Current shortcode tag
	 */
	function has_shortcode_r( $content, $tag = 'gravityview' ) {
		if ( false === strpos( $content, '[' ) ) {
			return false;
		}

		if ( shortcode_exists( $tag ) ) {

			$shortcodes = array();

			preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
			if ( empty( $matches ) ) {
				return false;
			}

			foreach ( $matches as $shortcode ) {
				if ( $tag === $shortcode[2] ) {

					// Changed this to $shortcode instead of true so we get the parsed atts.
					$shortcodes[] = $shortcode;

				} else if ( isset( $shortcode[5] ) && $results = has_shortcode_r( $shortcode[5], $tag ) ) {
					foreach ( $results as $result ) {
						$shortcodes[] = $result;
					}
				}
			}

			return $shortcodes;
		}

		return false;
	}
}

/**
 * Parse content for [gravityview] shortcodes
 *
 * @uses has_shortcode_r()
 * @uses shortcode_parse_atts()
 *
 * @param string $content
 *
 * @return array Associative array: (int)[View IDs] => (array)shortcode attributes
 */
function gravityview_parse_shortcodes( $content = '' ) {

	$shortcodes = has_shortcode_r( $content, 'gravityview' );

	$return = array();

	if( ! empty( $shortcodes ) ) {

		do_action('gravityview_log_debug', __METHOD__ . ': Parsing content, found shortcodes', $shortcodes );

		foreach ( $shortcodes as $key => $shortcode ) {

			$args = shortcode_parse_atts( $shortcode[3] );

			if ( empty( $args['id'] ) ) {
				continue;
			}

			$return[] = $args;
		}
	}

	return $return;
}