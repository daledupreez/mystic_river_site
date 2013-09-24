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
				$imageDir = esc_url( get_stylesheet_directory_uri() . "/images/" );
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>

			<div id="sponsors">
				<a id="link_coors" class="sponsor_link" href="http://www.coorslight.com" target="_blank" alt="Coors Light">
					<img class="sponsor_logo" src="<?php echo $imageDir; ?>coors_light_logo.png" />
				</a>
				<a id="link_harp" class="sponsor_link" href="http://www.harpboston.com" target="_blank" alt="The Harp">
					<img class="sponsor_logo" src="<?php echo $imageDir; ?>harp_logo.png" />
				</a>
				<a id="link_usa_rugby" class="sponsor_link" href="http://www.usarugby.org" target="_blank" alt="USA Rugby" title="USA Rugby">
					<img class="sponsor_logo" src="<?php echo $imageDir; ?>usa_rugby_logo.png" />
				</a>
				<a id="link_llanllyr" class="sponsor_link" href="http://www.llanllyrwater.com/" target="_blank" alt="Llanllyr Source Water">
					<img class="sponsor_logo" src="<?php echo $imageDir; ?>llanllyr_source_logo.png" />
				</a>
				<a id="link_ruggers" class="sponsor_link" href="http://www.ruggers.com/" target="_blank" alt="Ruggers">
					<img class="sponsor_logo" src="<?php echo $imageDir; ?>ruggers_logo.png" />
				</a>
			</div>

			<div id="site-generator">
				<a href="<?php echo esc_url( get_admin_url() ); ?>" title="Log in to Admin pages">Admin</a>
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="<?php echo esc_url( get_bloginfo('rss2_url') ); ?>" title="View RSS Feed">RSS</a>
				<!--
				<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="<?php echo esc_url( get_bloginfo('comments_rss2_url') ); ?>" title="View RSS Feed for Comments">Comments RSS</a>
				-->
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<div id="mystic_dialog_div" style="display: none;"></div>

<?php wp_footer(); ?>

</body>
</html>