<?php
/*
Plugin Name: WikiPress
Plugin URI: http://wikipress.rapprich.com/
Description: WikiPress adds a Wiki, or Wiki system to your WordPress installation.  Users can easily collaborate with one another using the bbcode syntax.  NOTE:  As of 2/24/09, WikiBoard access is limited to logged in users in the administration section.  This functionality, along with an "Active WikiBoards" dashboard widget & WikiBoard search, will be available in the coming update.
Author: Erik Rapprich
Version: 0.9.9
Author URI: http://www.rapprich.com
*/

/*  Copyright 2009 Erik Rapprich  (email : erik@rapprich.com)

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( !class_exists( 'Wiki_Press' ) ) {
	require_once(ABSPATH . 'wp-content/plugins/wikipress/class.wikipress.php');
}

if( class_exists( 'Wiki_Press' ) ) {
	$wikipress = new Wiki_Press();

	// Activation and Deactivation
	register_activation_hook( __FILE__, array( &$wikipress, 'on_activate' ) );
	register_deactivation_hook( __FILE__, array( &$wikipress, 'on_deactivate' ) );
	
	// Actions
	add_action( 'admin_menu', array( &$wikipress, 'on_admin_menu' ) );
	add_action( 'admin_head', array( &$wikipress, 'on_admin_head' ) );
	add_action( 'init', array( &$wikipress, 'on_init' ) );
}


?>
