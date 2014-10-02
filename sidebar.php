<?php
$default_template = of_get_option('single_template');
$custom_template = get_post_meta($post->ID, '_wp_post_template', true);
$custom_sidebar = largo_get_custom_sidebar();

// Make sure we're in the right context for a sidebar
if (
	($default_template == 'classic' && in_array($custom_template, array('', 'single-two-column.php'))) || // two column layout
	($custom_template == 'single-two-column.php') || // forced two column layout
	($custom_template == 'single-one-column.php' && $custom_sidebar !== 'none') // forced single column with custom sidebar
)
{
	$showey_hidey_class = (of_get_option('showey-hidey'))? 'showey-hidey':'';
	$span_class = is_single()? 'span2':'span4';

	do_action('largo_before_sidebar'); ?>
	<aside id="sidebar" class="<?php echo $span_class; ?>">
		<?php do_action('largo_before_sidebar_content'); ?>
		<div class="widget-area <?php echo $showey_hidey_class ?>" role="complementary">
			<?php
				do_action('largo_before_sidebar_widgets');

				if (is_single())
					get_template_part('partials/sidebar', 'single');
				else if (is_archive() && !is_date())
					get_template_part('partials/sidebar', 'archive');
				else
					get_template_part('partials/sidebar');

				do_action('largo_after_sidebar_widgets');
			?>
		</div>
		<?php do_action('largo_after_sidebar_content'); ?>
	</aside>
	<?php do_action('largo_after_sidebar');
}
