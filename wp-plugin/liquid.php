<?php

/*
Plugin Name: Liquid Information
Plugin URI: http://liquid.info/
Description: Enables the Liquid Information functionality.
Version: 1.0.0.1
Author URI: http://liquid.info/
*/
 
/*  Copyright 2011

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

/**
 * Hooks the WP init action to provide a JS object containing
 * data used for Liquid Information to function.
 *
 * @return void
 **/
function hw_init() {

	$settings = get_option( 'liquid' );
	$in_footer = false;
	wp_enqueue_script( 'liquid', hw_url() . 'liquid/settings/liquid/hyperwords.js', array( 'jquery' ), '1.0002', $in_footer );
	// Get the settings we've saved into the WP option

	$data = array(
		'basepath' => hw_url() . 'liquid/',
		'customerID' => 'liquid',
		'language' => 'en',
	);
	// This saves a JS script, which creates a JS object containing the data
	wp_localize_script( 'liquid', 'hw', $data );
}
add_action( 'init', 'hw_init' );

/**
 * Hooks the WP wp_head action early (priority zero) to add a META element
 *
 * @return void
 **/
function hw_wp_head() {
	$head = "\n\t<meta name='liquid' content='v1.0' />\n";
        $head .= "\n\t<meta http-equiv='X-UA-Compatible' content='IE=8' />\n";
        echo $head;
}
add_action( 'wp_head', 'hw_wp_head', 0 );

/**
 * Returns the URL for this plugin's containing directory
 *
 * @return string A URL
 **/
function hw_url() {
	$dir = basename( dirname( __FILE__ ) );
	return trailingslashit( WP_PLUGIN_URL ) . trailingslashit( $dir );
}

?>
