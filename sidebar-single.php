<?php
/**
 * The Sidebar containing the single widget area.
 */
?>
<div class="widget-area showey-hidey" role="complementary">
	<?php
		if ( ! dynamic_sidebar( 'sidebar-single' ) ) :
			the_widget( 'largo_follow_widget', array( 'title' => __('Follow Us', 'largo') ) );
			the_widget( 'largo_about_widget', array( 'title' => __('About This Site', 'largo') ) );
			if ( of_get_option( 'donate_link' ) )
				the_widget( 'largo_donate_widget', array(
					'title' 		=> __('Support ' . get_bloginfo('name'), 'largo'),
					'cta_text' 		=> __('We depend on your support. A generous gift in any amount helps us continue to bring you this service.', 'largo'),
					'button_text' 	=> __('Donate Now', 'largo'),
					'button_url' 	=> esc_url( of_get_option( 'donate_link' ) ),
					'widget_class' 	=> 'default'
					)
				);
			the_widget( 'largo_recent_posts_widget', array(
					'title' 		=> __('Recent Stories', 'largo'),
					'num_posts' 	=> 5,
					'num_sentences' => 2,
					'widget_class' 	=> 'default'
				)
			);
		endif;
	?>
</div><!-- #main .widget-area -->