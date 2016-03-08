<?php
/**
 * The template for displaying search forms
 */
?>
<form class="form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-append">
		<input type="text" placeholder="<?php _e('Search', 'largo'); ?>" class="searchbox search-query" value="" name="s" /><button type="submit" class="search-submit btn"><?php _e('Go', 'largo'); ?></button>
	</div>
</form>
