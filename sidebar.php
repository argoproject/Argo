<?php

if ((is_single() || is_singular()) && !largo_is_sidebar_required())
	return;

$showey_hidey_class = (of_get_option('showey-hidey'))? 'showey-hidey':'';
$span_class = is_single()? 'span2':'span4';

do_action('largo_before_sidebar'); ?>
<aside id="sidebar" class="<?php echo $span_class; ?>">
	<?php do_action('largo_before_sidebar_content'); ?>
	<div class="widget-area <?php echo $showey_hidey_class ?>" role="complementary">
		<?php
			do_action('largo_before_sidebar_widgets');

			if (is_archive() && !is_date())
				get_template_part('partials/sidebar', 'archive');
			else
				get_template_part('partials/sidebar');

			do_action('largo_after_sidebar_widgets');
		?>
	</div>
	<?php do_action('largo_after_sidebar_content'); ?>
</aside>
<?php do_action('largo_after_sidebar');
