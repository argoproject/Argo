<?php
/**
 * The Sidebar containing the single widget area.
 */
?>
<div class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-single' ) ) : ?>

	single sidebar

	<?php endif; // end sidebar widget area ?>
</div><!-- #main .widget-area -->