<?php

/**
 * Wrapper for wp_nav_menu() that previously cached nav menus. Removed caching mechanism and
 * changed function name to largo_nav_menu in 0.4. See largo_nav_menu.
 *
 * @since 0.3
 * @deprecated 0.4
 * @deprecated Use largo_nav_menu()
 * @see largo_nav_menu()
 *
 * @param array $args
 */
function largo_cached_nav_menu( $args = array(), $prime_cache = false ) {
	return largo_nav_menu($args);
}
_deprecated_function('largo_cached_nav_menu', '0.4', 'largo_nav_menu');
