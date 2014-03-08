<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $wp;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<meta name="description" content="Boston Rugby at its finest. Established in 1974, Mystic River Rugby Club is Boston's PREMIER Division I rugby team and prides itself on the best rugby facilities in the Northeast." />
<meta name="keywords" content="Boston Rugby, Rugby Boston, Mystic River Rugby Club, Mystic Rugby, Mystic River Rugby, Massachusetts Rugby, MA Rugby, Youth Rugby, Rookie Rugby" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!-- Open Graph items -->
<meta name="og:title" content="<?php echo esc_attr( wp_title('|', true, 'right') . get_bloginfo('name') ); ?>" />
<meta name="og:type" content="website" />
<?php
	$og_data = array(
		'description' => "Boston Rugby at its finest. Established in 1974, Mystic River Rugby Club is Boston's PREMIER Division I rugby team and prides itself on the best rugby facilities in the Northeast.",
		'image' => get_stylesheet_directory_uri() . '/images/mystic_logo_blue.png',
		'url' => home_url( add_query_arg( array(), $wp->request ) )
	);
	if ( is_singular() ) {
		the_post();
		$og_data['description'] = get_the_excerpt();
		$og_data['url'] = get_permalink();
		if (has_post_thumbnail()) {
			$og_data['image'] = wp_get_attachment_url( get_post_thumbnail_id() );
		}
		rewind_posts();
	}
	foreach ($og_data as $og_tag => $og_value) {
		echo '<meta name="og:' . $og_tag . '" content="' . esc_attr( $og_value ) . '" />';
	}
?>

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	/* Disabled for Mystic River
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	*/
	if ( is_page_template('template-schedule.php') ) {
		// Note: get_stylesheet_directory_uri() is needed to get the child theme path
		wp_enqueue_style( 'mystic-schedule', get_stylesheet_directory_uri() . '/css/schedule.css' );
		wp_enqueue_script( 'jquery' );
		// Note: get_stylesheet_directory_uri() is needed to get the child theme path
		wp_enqueue_script( 'mystic-schedule', get_stylesheet_directory_uri() . '/js/schedule.js', array( 'jquery' ) );
		wp_localize_script( 'mystic-schedule', 'schedule_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	if ( is_page_template('template-register.php') ) {
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-dialog' );
	}

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="mystic_bg">
	<div id="page" class="hfeed">
		<header id="branding" role="banner">
				<hgroup>
					<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
					<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
				</hgroup>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div id="mystic_header">
						<div id="mystic_header_players">
							<div id="mystic_header_text">
							</div>
						</div>
					</div>
				</a>

				<?php
					// Has the text been hidden?
					if ( 'blank' == get_header_textcolor() ) :
				?>
					<div class="only-search<?php if ( $header_image ) : ?> with-image<?php endif; ?>">
					<?php get_search_form(); ?>
					</div>
				<?php
					else :
				?>
					<?php get_search_form(); ?>
				<?php endif; ?>

				<nav id="access" role="navigation">
					<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
					<?php /* Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
					<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
					<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
					<?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #access -->
		</header><!-- #branding -->


		<div id="main">
