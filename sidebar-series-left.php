<?php
/**
 * The Sidebar for Series Landing Pages (lefthand column)
 */
global $post;
$sidebar_slug = $post->post_name . "_left";
?>
	<aside id="sidebar-left" class="span3">
		<div class="widget-area" role="complementary">
			<?php
				if ( is_active_sidebar( $sidebar_slug ) ) {
					dynamic_sidebar( $sidebar_slug );
				} else {
					_e( '<p>Please add widgets to this content area in the WordPress admin area under appearance > widgets.</p>', 'largo' );
				}
			?>
		</div><!-- .widget-area -->
	</aside>
<?php
