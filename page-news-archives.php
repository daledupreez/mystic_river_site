<?php
/**
 * Custom page template for displaying News Archives
 */

get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$latest_posts = new WP_Query( array( 'posts_per_page' => 5, 'paged' => $paged ) );
global $more;
global $wp_query;
?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<header class="page-header">
						<h1 class="page-title"><?php echo the_title(); ?></h1>
					</header>

					<?php

					$first = true;
					/* Start Custom Loop */
					while ( $latest_posts->have_posts() ) {
						$latest_posts->the_post();
						if ( $first ) {
							$first = false;
							if ( $paged > 1 ) {
								$main_query = $wp_query;
								$wp_query = $latest_posts;
								twentyeleven_content_nav( 'nav-above' );
								$wp_query = $main_query;
							}
						}

						/* enable <more> semantics; note that this MUST occur inside the custom loop AFTER the_post() */
						$more = 0;

						get_template_part( 'content', get_post_format() );
					}

					$main_query = $wp_query;
					$wp_query = $latest_posts;
					twentyeleven_content_nav( 'nav-below' );
					$wp_query = $main_query;

					wp_reset_postdata();
				?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>