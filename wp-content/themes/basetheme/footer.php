<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>


			<div id="site-info">
				<?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'site_map' ) ); #, 'link_after' => '</a>&nbsp&nbsp|&nbsp&nbsp<a>' ?>
				<!--a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php bloginfo( 'name' ); ?>
				</a-->
			</div><!-- #site-info -->

			<div id="site-generator">
				<!--?php do_action( 'basetheme_credits' ); ?>
				<a href="<?php echo esc_url( __('http://wordpress.org/', 'basetheme') ); ?>"
						title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'basetheme'); ?>" rel="generator">
					<?php printf( __('Proudly powered by %s.', 'basetheme'), 'WordPress' ); ?>
				</a-->
			  &copy; 2011 Gabor Foldes
			</div><!-- #site-generator -->

		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
