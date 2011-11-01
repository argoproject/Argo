<?php
/**
 * The Sidebar containing the main widget area.
 */
?>
<div class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-main' ) ) : ?>
	
	<?php the_widget( 'Argo_hosts_Widget','title=Blog Hosts' ); ?>
	
	<?php endif; // end sidebar widget area ?>
</div><!-- #main .widget-area -->