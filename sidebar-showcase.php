<?php
/**
 * The Sidebar containing the showcase widget area.
 */
?>
<div class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-showcase' ) ) : ?>

				<aside id="archives" class="widget">
					<h3 class="widget-title"><?php _e( 'Archives', 'twentyeleven' ); ?></h3>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>

	<?php endif; // end sidebar widget area ?>
</div><!-- #main .widget-area -->