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