<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $post;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'basetheme' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo strtr(get_bloginfo( 'name' ), array("Beginnings" => "<span style='font-weight: bold; color: #a29986'>Beginnings</span><span style='font-weight: normal; font-size: 10px; color: #00588e'>beta</span>")); ?></a>
					</span>
				</<?php echo $heading_tag; ?>>

				<div class="header-search">
  				<?php get_search_form(); ?>
				</div>

				<!--div id="site-description"><?php bloginfo( 'description' ); ?></div-->
			  <div class="login">
				  <ul>
<?php
					  if (!is_user_logged_in()) {
				      wp_register();
				    } else {
					    echo '<li><a href="'.admin_url('profile.php').'">My profile</a></li>';
					  }
?>
			      <li><?php wp_loginout(get_permalink( $post->ID )); ?></li>
				  </ul>
				</div>
				
<!--
				<?php
					// Check if this is a post or page, if it has a thumbnail, and if it's a big one
					if ( is_singular() &&
							has_post_thumbnail( $post->ID ) &&
							( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) ) &&
							$image[1] >= HEADER_IMAGE_WIDTH ) :
						// Houston, we have a new header image!
						echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
					else : ?>
						<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
					<?php endif; ?>
-->
			</div><!-- #branding -->

			<div id="access" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'basetheme' ); ?>"><?php _e( 'Skip to content', 'basetheme' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<!--?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?-->

				<div class="menu-header">
					<ul>
            <li><a href="<?php echo site_url(); ?>">Home</a></li>
<?php
						if (is_single() && in_array($post->post_type, array("startup", "person", "group"))) {
							$pt = get_post_type_object($post->post_type); $listpage = get_page_by_title( $pt->label );
    					echo '<li><span>></span><a href="'.$listpage->guid.'">'.$listpage->post_title.'</a></li>';
					  	  $parent_id = $post->post_parent;
					  	  $pregroups = "";
					  	  while ($parent_id > 0) {
					  		  $p = get_post($parent_id);
	    		  			$pregroups = '<li><span>></span><a href="'.$p->guid.'">'.$p->post_title.'</a></li>' . $pregroups;
					  		  $parent_id = $p->post_parent;
					  		}
					  		echo $pregroups;
							}
						?>
  					<?php if (!is_front_page()) : ?>
	            <li><span>></span><span><?php echo is_search() ? 'Search' : (is_archive() ? 'Categories' : $post->post_title); ?></span></li>
						<?php endif; ?>
					</ul>
				</div>


				<?php wp_nav_menu( array( 'container_class' => 'menu-header-right', 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->

		</div><!-- #masthead -->
	</div><!-- #header -->

	<div id="main">
