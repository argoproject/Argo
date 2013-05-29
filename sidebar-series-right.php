<?php
/**
 * The Sidebar for Series Landing Pages (righthand column)
 */
global $post;
$sidebar_slug = $post->post_name . "_right";
?>

<aside id="sidebar" class="span4">
	<?php do_action('largo_before_sidebar_content'); ?>
	<div class="widget-area" role="complementary">
		<?php
			do_action('largo_before_sidebar_widgets');

			if ( is_active_sidebar( $sidebar_slug ) ) {
				dynamic_sidebar( $sidebar_slug );
			} else {
				dynamic_sidebar( 'sidebar-main' );
			}

			do_action('largo_after_sidebar_widgets');
		?>
	</div><!-- .widget-area -->
	<?php do_action('largo_after_sidebar_content'); ?>
</aside>
