<?php

/*
Plugin Name: List Pages Shortcode
Plugin URI: http://www.aaronharp.com/dev/list-pages-shortcode/
Description: Introduces the [list-pages], [sibling-pages] and [child-pages] <a href="http://codex.wordpress.org/Shortcode_API">shortcodes</a> for easily displaying a list of pages within a post or page.  Both shortcodes accept all parameters that you can pass to the <a href="http://codex.wordpress.org/Template_Tags/wp_list_pages">wp_list_pages()</a> function.  For example, to show a page's child pages sorted by title simply add [child-pages sort_column="post_title"] in the page's content.
Author: Aaron Harp
Version: 1.1
Author URI: http://www.aaronharp.com
*/

function _build_page_list ($args) {

	$pages = get_posts($args);
	
	if ( $pages ) {
  	$out = $args['class'] ? '<ul class="' . $args['class'] . '">' : '<ul>';
  	foreach ($pages as $page) {
			$out .= '<li><a href="'.$page->guid.'">'.$page->post_title.'</a>';
			$args['post_parent'] = $page->ID;
			$out .= _build_page_list( $args );
			$out .= '</li>';
		}
		$out .= '</ul>';
	}

	return $out;
}

function shortcode_list_pages( $atts, $content, $tag ) {
	
	global $post;
	
	$args = array(
	    'orderby' => 'post_title',
			'order' => 'ASC',
	    'post_parent' => 0,
	    'post_type' => 'page',
	    'post_status' => 'publish',
			'class'       => $tag
	);
  $args = shortcode_atts( $args, $atts );
	
	// Set necessary params
	if ( $tag == 'child-pages' )
		$args['post_parent'] = $post->ID;
	if ( $tag == 'sibling-pages' )
		$args['post_parent'] = $post->post_parent;
	
	// Create output
	$out = _build_page_list( $args );
	
	return apply_filters( 'shortcode_list_pages', $out, $args, $content, $tag );
	
}

add_shortcode( 'child-pages', 'shortcode_list_pages' );
add_shortcode( 'sibling-pages', 'shortcode_list_pages' );
add_shortcode( 'list-pages', 'shortcode_list_pages' );

?>