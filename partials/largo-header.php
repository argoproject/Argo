<?php
/*
 * Largo Header
 *
 * Calls largo_header() output function and displays print header
 *
 * @package Largo
 * @see inc/header-footer.php
 */ ?>
 <header id="site-header" class="clearfix nocontent" itemscope itemtype="http://schema.org/Organization">
	<?php /* docs in inc/header-footer.php */
	largo_header(); ?>
</header>
<header class="print-header nocontent">
	<p>
		<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
		(<?php echo esc_url(
									/* Documented in inc/helpers.php */
									largo_get_current_url()
								); ?>)
	</p>
</header>
