<?php
/*
 * List all of the terms in a custom taxonomy
 */
class largo_prev_next_post_links_widget extends WP_Widget {

	function largo_prev_next_post_links_widget() {
		$widget_ops = array(
			'classname' 	=> 'largo-prev-next-post-links',
			'description' 	=> __('Prev/next post navigation, typically at the bottom of single posts; formerly a theme option.', 'largo')
		);
		$this->WP_Widget( 'largo-prev-next-post-links-widget', __('Largo Prev/Next Links', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $post;
		extract( $args );

		// only useful on post pages
		if ( !is_single() ) return;

		echo $before_widget;

		largo_content_nav('single-post-nav-below');

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		//$instance = $old_instance;
		//$instance['title'] = strip_tags($new_instance['title']);
		return $new_instance;
	}

	//nothing to see here
	function form( $instance ) {}

}
