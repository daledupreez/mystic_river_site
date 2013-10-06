<?php

// In child themes the functions.php is applied before the parent
// theme's functions.php. So we need to wait for the parent theme to add 
// it's filter before we can remove it.
add_action( 'after_setup_theme', 'my_child_theme_setup' );

add_action('init','mystic_init');

add_filter('widget_display_callback', 'mystic_filter_widget_display');

function my_child_theme_setup() {
	// Removes the filter that adds the "singular" class to the body element
	// which centers the content and does not allow for a sidebar
	remove_filter( 'body_class', 'twentyeleven_body_classes' );
	
	/* Remove the twentyeleven registered sidebars */
	//remove_action( 'widgets_init', 'twentyeleven_widgets_init' );
	/* Add the modified version of the widgets_init function in this file */
	//add_action( 'widgets_init', 'mystic_widgets_init' );
}

function mystic_init() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('mystic_js', get_stylesheet_directory_uri() . '/js/mystic.js', array('jquery'));
	add_action('wp_footer','mystic_onload_script');
}

function mystic_onload_script() {
?>
<script type="text/javascript">
if (window.jQuery) {
	jQuery(document).ready(function() { if (window.mystic) mystic.handler.load(); } );
}
</script>
<?php
}

function mystic_filter_widget_display( $widget_instance )
{
	$blocked_titles = array( 'Archives', 'Categories', 'Monthly Archives', 'Tag Cloud', 'Tags' );
	if ( ( !empty($widget_instance['title']) ) && ( in_array($widget_instance['title'], $blocked_titles) ) ) {
		if ( !is_page() || ( get_the_title() != 'News Archives' ) ) {
			return false;
		}
	}
	return $widget_instance;
}

/**
 * Display navigation to next/previous pages when applicable
 * Overridden to avoid using "posts" in the text.
 */
function twentyeleven_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/**
 * Register our sidebars and widgetized areas. Also register the default Ephemera widget.
 * Overridden from twentyeleven_widgets_init to specify that sidebar-1 should have closed as a class
 */
function mystic_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s closed">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Showcase Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the optional Showcase Template', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'twentyeleven' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'twentyeleven' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'twentyeleven' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
?>