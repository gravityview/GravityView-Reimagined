<?php
/**
 * Plugin Name:       	GravityView Reloaded
 * Plugin URI:        	http://gravityview.co
 * Description:       	Create directories based on a Gravity Forms form, insert them using a shortcode, and modify how they output.
 * Version:          	2.0-bleeding-edge
 * Author:            	Katz Web Services, Inc.
 * Author URI:        	http://www.katzwebservices.com
 * Text Domain:       	gravityview
 * License:           	GPLv2 or later
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:			/languages
 */

function gravityview() {
	
	if( ! class_exists( 'GV_Mission_Control' ) ) {
		include_once plugin_dir_path( __FILE__ ) . 'class-gv-mission-control.php';
	}
	
	return GV_Mission_Control::get_instance();
}

gravityview();

