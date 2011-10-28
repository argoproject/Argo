<?php
/**
 * The Footer widget areas.
 */
?>

<div class="grid_2 widget-area" role="complementary">

	<?php if ( ! dynamic_sidebar( 'footer-1' ) ) : ?>
		<?php the_widget( 'Argo_follow_Widget','title=Follow us' ); ?>
	<?php endif; // end sidebar widget area ?>
	
</div> <!-- /.grid_2 -->

<div class="grid_6 widget-area" role="complementary">

	<?php if ( ! dynamic_sidebar( 'footer-2' ) ) : ?>
		<?php the_widget( 'Argo_more_featured_Widget','title=Don\'t Miss' ); ?>
	<?php endif; // end sidebar widget area ?>
	
</div> <!-- /.grid_6 -->

<div class="grid_4 widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'footer-3' ) ) : ?>
	
	<div id="searchform-footer">
		<?php get_search_form(); ?>
	</div>
	
	<div id="ft-archive">
    	<h3>Browse archives by date</h3>
		<select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'> 
			<option value="">Select Month</option> 
			<?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?> </select>
	</div>

<?php endif; // end sidebar widget area ?>
</div> <!-- /.grid_4 -->

