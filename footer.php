<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>

			<div id="site-generator">
				<a href="<?php echo esc_url( get_admin_url() ); ?>" title="Log in to Admin pages">Admin</a>
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="<?php echo esc_url( get_bloginfo('rss2_url') ); ?>" title="View RSS Feed for News">News RSS</a>
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="<?php echo esc_url( get_bloginfo('comments_rss2_url') ); ?>" title="View RSS Feed for Comments">Comments RSS</a>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<div id="mystic_dialog_div" style="display: none;"></div>

<?php wp_footer(); ?>

</body>
</html>