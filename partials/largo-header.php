<?php
/*
 * Largo Header
 *
 * Calls largo_header() output function and displays print header
 *
 * @package Largo
 * @see inc/header-footer.php
 */
if ( ! is_single() && ! is_singular() || ! of_get_option( 'main_nav_hide_article', false ) ) {
?>
<header id="site-header" class="clearfix nocontent" itemscope itemtype="http://schema.org/Organization">
	<?php
	/**
	 * Before largo_header()
	 *
	 * Use add_action( 'largo_header_before_largo_header', 'function_to_add');
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_action
	 * @since 0.5.5
	 */
	do_action('largo_header_before_largo_header');

	largo_header();

	/**
	 * After largo_header()
	 *
	 * Use add_action( 'largo_header_after_largo_header', 'function_to_add');
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_action
	 * @since 0.5.5
	 */
	do_action('largo_header_after_largo_header');

	?>
</header>
<header class="print-header nocontent">
	<p>
		<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
		(<?php /* Documented in inc/helpers.php */
			echo esc_url( largo_get_current_url() ); ?>)
	</p>
</header>
<?php }
