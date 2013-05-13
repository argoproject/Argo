<?php
/**
 * The Sidebar for Series Landing Pages (lefthand column)
 */
global $post;
$sidebar_slug = $post->post_name . "_left";

if ( is_active_sidebar( $sidebar_slug ) ) :

?>
<aside id="sidebar-left" class="span3">
	<?php do_action('largo_before_sidebar_content'); ?>
	<div class="widget-area<?php if ( is_single() && of_get_option( 'showey-hidey' ) ) echo ' showey-hidey'; ?>" role="complementary">
		<?php
			do_action('largo_before_sidebar_widgets');
			global $post;
			dynamic_sidebar($post->post_name . "_left");
			do_action('largo_after_sidebar_widgets');
		?>
	</div><!-- .widget-area -->
	<?php do_action('largo_after_sidebar_content'); ?>
</aside>
<?php
endif;