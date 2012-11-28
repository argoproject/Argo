<?php

// remove default WP widgets
function largo_unregister_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Text' );
}
add_action( 'widgets_init', 'largo_unregister_widgets' );

// load our new widgets
require_once( get_template_directory() . '/inc/widgets/largo-follow.php' );
require_once( get_template_directory() . '/inc/widgets/largo-footer-featured.php' );
require_once( get_template_directory() . '/inc/widgets/largo-sidebar-featured.php' );
require_once( get_template_directory() . '/inc/widgets/largo-about.php' );
require_once( get_template_directory() . '/inc/widgets/largo-donate.php' );
require_once( get_template_directory() . '/inc/widgets/largo-twitter.php' );
require_once( get_template_directory() . '/inc/widgets/largo-recent-posts.php' );
require_once( get_template_directory() . '/inc/widgets/largo-inn-rss.php' );
require_once( get_template_directory() . '/inc/widgets/largo-taxonomy-list.php' );
require_once( get_template_directory() . '/inc/widgets/largo-facebook.php' );
require_once( get_template_directory() . '/inc/widgets/largo-text.php' );
require_once( get_template_directory() . '/inc/widgets/largo-recent-comments.php' );

// and then register them
function largo_load_widgets() {
    register_widget( 'largo_follow_widget' );
    register_widget( 'largo_footer_featured_widget' );
    register_widget( 'largo_sidebar_featured_widget' );
    register_widget( 'largo_about_widget' );
    register_widget( 'largo_donate_widget' );
    register_widget( 'largo_twitter_widget' );
    register_widget( 'largo_recent_posts_widget' );
    register_widget( 'largo_INN_RSS_widget' );
    register_widget( 'largo_taxonomy_list_widget' );
    register_widget( 'largo_facebook_widget' );
    register_widget( 'largo_text_widget' );
    register_widget( 'largo_recent_comments_widget' );
}
add_action( 'widgets_init', 'largo_load_widgets' );

// add odd/even and incremental counter classes to widgets
function add_odd_even_widget_classes($params) {
	global $widget_num;

	// Widget class
	$class = array();
	$class[] = 'widget';

	// Iterated class
	$widget_num++;
	$class[] = 'widget-' . $widget_num;

	// Alt class
	if ($widget_num % 2) :
		$class[] = 'odd';
	else :
		$class[] = 'even';
	endif;

	// Join the classes in the array
	$class = join(' ', $class);

	// Interpolate the 'my_widget_class' placeholder
	$params[0]['before_widget'] = str_replace('odd_even', $class, $params[0]['before_widget']);
	return $params;
}
add_filter('dynamic_sidebar_params', 'add_odd_even_widget_classes');

// reset counter for each sidebar
add_filter('get_sidebar','widget_counter_reset', 99);
function widget_counter_reset($text) {
   global $widget_num;
   $widget_num = 0;
   return $text;
}

?>