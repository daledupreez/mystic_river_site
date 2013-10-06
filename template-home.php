<?php
/*
Template Name: Home Template
*/

/**
 * The home template for the Mystic River theme.
 *
 * This is based off the Twenty Eleven index.php, with the nav controls removed and a custom loop with four posts.
 *
 */

get_header();
$latest_posts = new WP_Query( array( 'posts_per_page' => 4 ) );
 ?>

		<div id="primary">
			<div id="content" role="main">

			<?php if ( $latest_posts->have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php echo the_title(); ?></h1>
				</header>

				<?php
					/* Don't show top nav controls */
					/* twentyeleven_content_nav( 'nav-above' ); */
					
					global $more;
					/* Start Custom Loop */
					while ( $latest_posts->have_posts() ) {
						$latest_posts->the_post();
						/* enable <more> semantics; note that this MUST occur inside the custom loop AFTER the_post() */
						$more = 0;

						get_template_part( 'content', get_post_format() );
					}

					/* Don't show bottom nav controls either */
					/* twentyeleven_content_nav( 'nav-below' ); */
				?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>