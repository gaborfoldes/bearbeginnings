<?php
/*
Plugin Name: WordPress Wiki That Doesn't Suck (WPWTDS)
Description: A WordPress Wiki that works.
Version: 0.6.1
Author: Arcane Palette Creative Design
Author URI: http://arcanepalette.com/
License: gpl3
*/

/* here are some constants */
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

/* this adds an admin menu */

/* saving this for when I have time and/or figure out how to make the form actually save the setting

add_action('admin_menu', 'wpwtds_menu');

function wpwtds_menu() {

  add_submenu_page( 'edit.php?post_type=wpwtds_article', __('WordPress Wiki Options That Don\'t Suck'), __('Options'), 'manage_options', 'wpwtds_options', wpwtds_options);
  
}


function wpwtds_options() {

  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

  echo '<div class="wrap">';
  echo '<h2>WordPress Wiki Options That Don\'t Suck</h2>';
  echo '<form method="post">';
  echo '<table class="form-table">';
  echo '<tbody>';
  echo '<tr valign="top">';
  echo '<th scope="row">';
  echo '<label for="slugname">Your Wiki\'s Slug</label>';
  echo '</th>';
  echo '<td>';
  echo '<input name="slug" type="text" id="wpwtdsslug" value="wiki" class="regular-text"><span class="description">You can change the default slug for your wiki pages.  Default is "wiki".</span>';
  echo '</td>';
  echo '</tr>';
  echo '</tbody>';
  echo '</table>';
  echo '<p class="submit">';
  echo '<input type="submit" name="Submit" class="button-primary" value="Save Changes">';
  echo '</p>';
  echo '</form>';
  echo '</div>';
}
*/

/* creates a custom post type with a bunch of defined parameters */
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'wpwtds_article',
    array(
      'labels' => array(
		'name' => __( 'Wiki != suck' ),
		'singular_name' => __( 'Article' ),
		'add_new' => __( 'Post New Wiki' ),
		'add_new_item' => __( 'Add New Article' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Wiki' ),
		'new_item' => __( 'New Wiki' ),
		'view' => __( 'View Wiki' ),
		'view_item' => __( 'View Wiki' ),
		'search_items' => __( 'Search Articles' ),
		'not_found' => __( 'No articles found' ),
		'not_found_in_trash' => __( 'No articles found in Trash' ),
		'parent' => __( 'Parent Wiki' ),
      ),
      'public' => true,
	  'rewrite' => array('slug' => 'wiki','with_front' => 'false'),
	  'supports' => array('title','editor','revisions','author')
    )
  );
}

add_action( 'admin_head', 'wpwtds_icon' );
function wpwtds_icon() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-wpwtdsarticle .wp-menu-image {
            background: url(<?php bloginfo('url'); ?>/wp-content/plugins/ap-wpwtds/images/wiki.png) no-repeat bottom !important;
			opacity: 0.7;
			-moz-opacity: 0.7;
			-webkit-opacity: 0.7;
			filter:alpha(opacity=70)
        }
	#menu-posts-wpwtdsarticle:hover .wp-menu-image, #menu-posts-wpwtdsarticle.wp-has-current-submenu .wp-menu-image {
			opacity: 1.0;
			-moz-opacity: 1.0;
			-webkit-opacity: 1.0;
			filter:alpha(opacity=100)
        }
    </style>

<?php } ?>
