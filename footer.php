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

				<div id="footer_links">
					<a id="link_coors" class="footer_link" href="http://www.coorslight.com" target="_blank" alt="Coors Light">
						<img class="footer_link_image" src="<?php echo $imageDir; ?>coors_light_logo.png" />
					</a>
					<a id="link_harp" class="footer_link" href="http://www.harpboston.com" target="_blank" alt="The Harp">
						<img class="footer_link_image" src="<?php echo $imageDir; ?>harp_logo.png" />
					</a>
					<a id="link_cha" class="footer_link" href="http://www.challiance.org/Services/SportsMedicine.aspx" target="_blank" alt="CHA Sports Medicine">
						<img class="footer_link_image" src="<?php echo $imageDir; ?>cha_sports_medicine_logo.png" />
					</a>
					<a id="link_usa_rugby" class="footer_link" href="http://www.usarugby.org" target="_blank" alt="USA Rugby" title="USA Rugby">
						<img class="footer_link_image" src="<?php echo $imageDir; ?>usa_rugby_logo.png" />
					</a>
					<a id="link_cwm" class="footer_link" href="http://www.cwmofnewengland.com/" target="_blank" alt="Concord Wealth Management">
						<img class="footer_link_image" src="<?php echo $imageDir; ?>cwm_logo.png" />
					</a>
					<a id="link_jameson" class="footer_link" href="https://www.jamesonwhiskey.com/us/" target="_blank" alt="Jameson Irish Whiskey">
						<img class="footer_link_image" src="<?php echo $imageDir; ?>jameson_logo.png" />
					</a>
				</div>

				<div id="site-generator">
					<a href="<?php echo esc_url( get_admin_url() ); ?>" title="Log in to Admin pages" style="color: white;">Admin</a>
					<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
					<a href="<?php echo esc_url( get_bloginfo('rss2_url') ); ?>" title="View RSS Feed" style="color: white;">RSS</a>
					<!--
					<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
					<a href="<?php echo esc_url( get_bloginfo('comments_rss2_url') ); ?>" title="View RSS Feed for Comments">Comments RSS</a>
					-->
				</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->
</div><!-- #mystic_bg -->
<div id="mystic_dialog_div" style="display: none;"></div>

<?php wp_footer(); ?>

</body>
</html>