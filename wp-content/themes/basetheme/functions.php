<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, basetheme_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'basetheme_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run basetheme_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'basetheme_setup' );

if ( ! function_exists( 'basetheme_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override basetheme_setup() in a child theme, add your own basetheme_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function basetheme_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'basetheme', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'basetheme' ),
		'site_map' => __( 'Site Map', 'basetheme' )
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to basetheme_header_image_width and basetheme_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'basetheme_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'basetheme_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See basetheme_admin_header_style(), below.
	add_custom_image_header( '', 'basetheme_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'basetheme' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'basetheme' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'basetheme' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'basetheme' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'basetheme' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'basetheme' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'basetheme' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'basetheme' )
		)
	) );
}
endif;

if ( ! function_exists( 'basetheme_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in basetheme_setup().
 *
 * @since Twenty Ten 1.0
 */
function basetheme_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function basetheme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'basetheme_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function basetheme_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'basetheme_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function basetheme_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and basetheme_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function basetheme_auto_excerpt_more( $more ) {
	return ' &hellip;' . basetheme_continue_reading_link();
}
add_filter( 'excerpt_more', 'basetheme_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function basetheme_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= basetheme_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'basetheme_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function basetheme_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'basetheme_remove_gallery_css' );

if ( ! function_exists( 'basetheme_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own basetheme_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function basetheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'basetheme' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'basetheme' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'basetheme' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'basetheme' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'basetheme' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'basetheme'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override basetheme_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function basetheme_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'basetheme' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'basetheme' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'basetheme' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'basetheme' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'basetheme' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'basetheme' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running basetheme_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'basetheme_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function basetheme_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'basetheme_remove_recent_comments_style' );

if ( ! function_exists( 'basetheme_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function basetheme_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'basetheme' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'basetheme' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'basetheme_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function basetheme_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'basetheme' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'basetheme' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'basetheme' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/*----------------------------------------------------*/

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
	    'orderby' => 'title',
			'order' => 'ASC',
	    'post_parent' => 0,
	    'post_type' => 'page',
	    'post_status' => 'publish',
			'class'       => $tag,
			'numberposts' => -1
	);
  $args = shortcode_atts( $args, $atts );
	
	// Set necessary params
#	if ( $tag == 'child-pages' ) $args['post_parent'] = $post->ID;
#	if ( $tag == 'sibling-pages' ) $args['post_parent'] = $post->post_parent;


	$out = _build_page_list( $args );
	
	return apply_filters( 'shortcode_list_pages', $out, $args, $content, $tag );
	
}

#add_shortcode( 'child-pages', 'shortcode_list_pages' );
#add_shortcode( 'sibling-pages', 'shortcode_list_pages' );
add_shortcode( 'list-pages', 'shortcode_list_pages' );



function create_custom_post_types() {

$startup_labels = array(
    'name' => _x('Startups', 'post type general name'),
    'singular_name' => _x('Startup', 'post type singular name'),
    'add_new' => _x('Add New', 'startup'),
    'add_new_item' => __('Add New Startup'),
    'edit_item' => __('Edit Startup'),
    'new_item' => __('New Startup'),
    'view_item' => __('View Startup'),
    'search_items' => __('Search Startups'),
    'not_found' =>  __('No startups found'),
    'not_found_in_trash' => __('No startups found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Startups'
);


register_post_type('startup',
    array(
        'label'           => __('Startups'),
			  'labels'          => $startup_labels,
        'public'          => true,
        'show_ui'         => true,
        'query_var'       => 'startup',
        'rewrite'         => array('slug' => 'startup'),
        'hierarchical'    => false,
        'supports'        => array(
            'title',
						'editor',
#            'excerpt',
            'thumbnail',
						'custom-fields',
						'revisions'
            ),
        )
);


register_taxonomy('startup-category', 'startup', array(
    'hierarchical'    => false,
    'label'           => __('Categories'),
    'query_var'       => 'startup-category',
    'rewrite'         => array('slug' => 'categories' ),
    )
);

/*
register_taxonomy('company-status', 'company', array(
    'hierarchical'    => true,
    'label'           => __('Status'),
    'query_var'       => 'company-status',
    'rewrite'         => array('slug' => 'status' ),
    )
);

register_taxonomy('company-funding', 'company', array(
    'hierarchical'    => true,
    'label'           => __('Funding'),
    'query_var'       => 'company-funding',
    'rewrite'         => array('slug' => 'funding' ),
    )
);*/

$person_labels = array(
    'name' => _x('People', 'post type general name'),
    'singular_name' => _x('Person', 'post type singular name'),
    'add_new' => _x('Add New', 'person'),
    'add_new_item' => __('Add New Person'),
    'edit_item' => __('Edit Person'),
    'new_item' => __('New Person'),
    'view_item' => __('View Person'),
    'search_items' => __('Search People'),
    'not_found' =>  __('No people found'),
    'not_found_in_trash' => __('No people found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'People'
);

register_post_type('person',
    array(
        'label'           => __('People'),
				'labels'					=> $person_labels,
        'public'          => true,
        'show_ui'         => true,
        'query_var'       => 'person',
        'rewrite'         => array('slug' => 'person'),
        'hierarchical'    => false,
        'supports'        => array(
            'title',
            'thumbnail',
            'editor'
            ),
        )
);


$group_labels = array(
    'name' => _x('Groups', 'post type general name'),
    'singular_name' => _x('Group', 'post type singular name'),
    'add_new' => _x('Add New', 'group'),
    'add_new_item' => __('Add New Group'),
    'edit_item' => __('Edit Group'),
    'new_item' => __('New Group'),
    'view_item' => __('View Group'),
    'search_items' => __('Search Groups'),
    'not_found' =>  __('No groups found'),
    'not_found_in_trash' => __('No groups found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Groups'
);


register_post_type('group',
    array(
        'label'           => __('Groups'),
				'labels'					=> $group_labels,
        'public'          => true,
        'show_ui'         => true,
        'query_var'       => 'group',
        'rewrite'         => array('slug' => 'group'),
        'hierarchical'    => true,
        'supports'        => array(
            'title',
            'thumbnail',
						'page-attributes',
            'editor'
            ),
        )
);


}

function setup_connections() {
	
    if ( !function_exists('p2p_register_connection_type') )
        return;

    p2p_register_connection_type( 'startup', 'person', true );
    p2p_register_connection_type( 'person', 'group', true );
    p2p_register_connection_type( 'startup', 'group', true );

}

add_action( 'init', 'create_custom_post_types' );
add_action( 'init', 'setup_connections', 100);


function widget_startupDetails($args) {

  global $post;

  if ($post->post_type != 'startup' || !is_single()) return;

  extract($args);
	echo $before_widget.$before_title.$widget_name;
	edit_post_link( __( 'edit', 'basetheme' ), '<span class="edit-link">', '</span>' );
	echo $after_title;

  $website = field_get_meta('website');
  $blogsite = field_get_meta('blog');
  $twitter = field_get_meta('twitter');
  $desc = field_get_meta('description');
  $phone = field_get_meta('phone');
  $email = field_get_meta('email');
  $team = field_get_meta('team-members');
  $started = field_get_meta('started');
  $offices = field_get_meta('offices',false);

?>
  <table>
<?php
?>
<?php if ($website) { ?>  <tr><td>Website</td><td><a href="<?php echo (preg_match('^(https?)\:\/\/', $website) ? $website : 'http://'.$website); ?>"><?php echo $website; ?><a></td></tr> <?php } ?>
<?php if ($blogsite) { ?> <tr><td>Blog</td><td><a href="<?php echo (preg_match('^(https?)\:\/\/', $blogsite) ? $blogsite : 'http://'.$blogsite); ?>"><?php echo $blogsite; ?><a></td></tr> <?php } ?>
<?php if ($twitter) { ?>  <tr><td>Twitter</td><td><a href="http://twitter.com/<?php echo $twitter; ?>">@<?php echo $twitter; ?><a></td></tr> <?php } ?>
<?php if ($phone) { ?>		<tr><td>Phone</td><td><?php echo $phone; ?></td></tr> <?php } ?>
<?php if ($email) { ?>		<tr><td>Email</td><td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?><a></td></tr> <?php } ?>

<?php if ($offices[0]) { ?>	 <tr><td>Offices</td><td><?php 
	 foreach ($offices as $office) echo $office."<br>"; ?></td></tr> <?php } ?>

<?php if ($team) { ?>		  <tr><td>Team size</td><td><?php echo $team; ?></td></tr> <?php } ?>
<?php if ($started) { ?>			<tr><td>Started</td><td><?php echo $started; ?></td></tr> <?php } ?>
<?php echo get_the_term_list($post->ID, 'startup-category', '<tr><td>Category</td><td>', '; ', '</td></tr>'); ?>
<?php if ($desc) { ?>			<tr><td>Description</td><td><?php echo $desc; ?></td></tr> <?php } ?>
<?php

  $other_fields = get_post_custom($post->ID);
  foreach ( $other_fields as $key => $value ) {
		if (substr($key,0,1) != "_") echo "<tr><td>".$key."</td><td>".$value[0]."</td></tr>";
  }

?>

	</table>

<?php
  echo $after_widget;

}

function widget_groupDetails($args) {

  global $post;

  if ($post->post_type != 'group' || !is_single()) return;

  extract($args);
	echo $before_widget.$before_title.$widget_name;
	edit_post_link( __( 'edit', 'basetheme' ), '<span class="edit-link">', '</span>' );
	echo $after_title;

  $website = field_get_meta('website');
  $blogsite = field_get_meta('blog');
  $twitter = field_get_meta('twitter');
  $desc = field_get_meta('description');
  $phone = field_get_meta('phone');
  $email = field_get_meta('email');
  $team = field_get_meta('team-members');
  $started = field_get_meta('started');
  $offices = field_get_meta('offices',false);

?>
  <table>
<?php
?>
<?php if ($website) { ?>  <tr><td>Website</td><td><a href="<?php echo (preg_match('^(https?)\:\/\/', $website) ? $website : 'http://'.$website); ?>"><?php echo $website; ?><a></td></tr> <?php } ?>
<?php if ($blogsite) { ?> <tr><td>Blog</td><td><a href="<?php echo (preg_match('^(https?)\:\/\/', $blogsite) ? $blogsite : 'http://'.$blogsite); ?>"><?php echo $blogsite; ?><a></td></tr> <?php } ?>
<?php if ($twitter) { ?>  <tr><td>Twitter</td><td><a href="http://twitter.com/<?php echo $twitter; ?>">@<?php echo $twitter; ?><a></td></tr> <?php } ?>
<?php if ($phone) { ?>		<tr><td>Phone</td><td><?php echo $phone; ?></td></tr> <?php } ?>
<?php if ($email) { ?>		<tr><td>Email</td><td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?><a></td></tr> <?php } ?>

<?php if ($offices[0]) { ?>	 <tr><td>Offices</td><td><?php 
	 foreach ($offices as $office) echo $office."<br>"; ?></td></tr> <?php } ?>

<?php if ($team) { ?>		  <tr><td>Team size</td><td><?php echo $team; ?></td></tr> <?php } ?>
<?php if ($started) { ?>			<tr><td>Started</td><td><?php echo $started; ?></td></tr> <?php } ?>
<?php if ($desc) { ?>			<tr><td>Description</td><td><?php echo $desc; ?></td></tr> <?php } ?>
<?php

  $other_fields = get_post_custom($post->ID);
  foreach ( $other_fields as $key => $value ) {
		if (substr($key,0,1) != "_") echo "<tr><td>".$key."</td><td>".$value[0]."</td></tr>";
  }

?>

	</table>

<?php
  echo $after_widget;

}

function widget_relatedPeople($args) {

  global $post;

  if (!in_array($post->post_type, array('group','startup')) || !is_single()) return;

  extract($args);

	$people = get_posts( array(
	  'suppress_filters' => false,
	  'post_type' => 'person',
	  'connected' => $post->ID,
	  'orderby' => 'title',
		'order' => 'ASC',
	  'numberposts' => 20
	) );

  if ($people) {

	echo $before_widget.$before_title.$widget_name;
	edit_post_link( __( 'edit', 'basetheme' ), '<span class="edit-link">', '</span>' );
	echo $after_title."<ul>";

  foreach ( $people as $person ) {

		if(has_post_thumbnail($person->ID)) {
			$thumb = get_the_post_thumbnail($person->ID);
			$thumb = preg_replace('/width=\S*/', 'width="30"', $thumb);
			$thumb = preg_replace('/height=\S*/', '', $thumb);
		} else $thumb = "";
?>
		<li><a href="<?php echo $person->guid; ?>"><?php echo $thumb." ".$person->post_title; ?></a></li>
<?php
  }

  echo "</ul>".$after_widget;

	}

}

function widget_relatedStartups($args) {

  global $post;

  if (!in_array($post->post_type, array('person','group')) || !is_single()) return;

  extract($args);

	$startups = get_posts( array(
	  'suppress_filters' => false,
	  'post_type' => 'startup',
	  'connected' => $post->ID,
	  'orderby' => 'title',
		'order' => 'ASC',
	  'numberposts' => 20
	) );

  if ($startups) {

		echo $before_widget.$before_title.$widget_name;
		edit_post_link( __( 'edit', 'basetheme' ), '<span class="edit-link">', '</span>' );
		echo $after_title."<ul>";

  foreach ( $startups as $startup ) {

		if(has_post_thumbnail($startup->ID)) {
			$thumb = get_the_post_thumbnail($startup->ID);
			$thumb = preg_replace('/width=\S*/', 'width="30"', $thumb);
			$thumb = preg_replace('/height=\S*/', '', $thumb);
		} else $thumb = "";
?>
		<li><a href="<?php echo $startup->guid; ?>"><?php echo $thumb." ".$startup->post_title; ?></a></li>
<?php
  }

  echo "</ul>".$after_widget;
 
  }

}

function widget_relatedGroups($args) {

  global $post;

  if (!in_array($post->post_type, array('person','startup')) || !is_single()) return;

  extract($args);

	$groups = get_posts( array(
	  'suppress_filters' => false,
	  'post_type' => 'group',
	  'connected' => $post->ID
	) );

	if ($groups) {

		echo $before_widget.$before_title.$widget_name;
		edit_post_link( __( 'edit', 'basetheme' ), '<span class="edit-link">', '</span>' );
		echo $after_title."<ul>";

  foreach ( $groups as $group ) {

		if(has_post_thumbnail($group->ID)) {
			$thumb = get_the_post_thumbnail($group->ID);
			$thumb = preg_replace('/width=\S*/', 'width="30"', $thumb);
			$thumb = preg_replace('/height=\S*/', '', $thumb);
		} else $thumb = "";
?>
		<li><a href="<?php echo $group->guid; ?>"><?php echo $thumb." ".$group->post_title; ?></a></li>
<?php
  }

  echo "</ul>".$after_widget;

  }

}

function widget_About($args) {

  global $post;

  if (!is_front_page()) return;

  extract($args);

  echo $before_widget.$before_title.'What is berkeleyBase?'.$after_title;
?>
  <ul>
     <li><strong>berkeleyBase</strong> is a database of startup initiatives as well as people and various groups involved in entrepreneurship in and around the university campus. It functions like a wiki so that anyone can edit the information.</li>
     <li>The site is exclusive to the UC Berkeley community.  You can either access it from the campus network or register using a 'berkeley.edu' email address.</li>
     <li>Help the Berkeley entrepreneur community by expanding the information on this site.</li>
  </ul>
<?php
  echo $after_widget;

}

function widget_Contribute($args) {

  global $post;

/*  if (!is_user_logged_in()) return;*/

  extract($args);

  echo $before_widget.$before_title.$widget_name.$after_title.'<ul>';

/*  $browse_page[0] = get_page_by_title("Startups"); 
  $browse_page[1] = get_page_by_title("People"); 
  $browse_page[2] = get_page_by_title("Groups"); 

  foreach ($browse_page as $bp) {
		echo '<li><a href="'.$bp->guid.'">'.$bp->post_title.'</a></li>';
	}
*/

  if (!is_user_logged_in()) { echo '<li>'; wp_loginout(); echo ' to contribute</li>'; }
#  else {	
  	echo '<li><a href="'.admin_url().'post-new.php?post_type=startup">Add a new startup</a></li>';
  	echo '<li><a href="'.admin_url().'post-new.php?post_type=person">Add a new person</a></li>';
   	echo '<li><a href="'.admin_url().'post-new.php?post_type=group">Add a new group</a></li>';
#  }

  echo '</ul>'.$after_widget;

}

function widget_Comments($args) {

  global $post;

  extract($args);

  echo $before_widget.$before_title.$widget_name.$after_title.'<ul>';

  $bp = get_page_by_title("Comments"); 
	echo '<li><a href="'.$bp->guid.'">Post a comment</a></li>';
  echo '</ul>'.$after_widget;

}


 
register_sidebar_widget(__('Startup Details'), 'widget_startupDetails');
register_sidebar_widget(__('Group Details'), 'widget_groupDetails');
register_sidebar_widget(__('People'), 'widget_relatedPeople');
register_sidebar_widget(__('Startups'), 'widget_relatedStartups');
register_sidebar_widget(__('Groups'), 'widget_relatedGroups');
register_sidebar_widget(__('About'), 'widget_About');
register_sidebar_widget(__('Contribute'), 'widget_Contribute');
register_sidebar_widget(__('Suggestions?'), 'widget_Comments');

#add_theme_support( 'post-thumbnails', array( 'post','startup','person','organization' ) );
#set_post_thumbnail_size( 50, 50, true );