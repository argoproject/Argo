<?php
/**
 * The template for displaying search forms
 */
?>
<form class="form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-append">
		<input type="text" placeholder="<?php _e('Search', 'largo'); ?>" class="searchbox search-query" value="<?php the_search_query(); ?>" name="s" />
		<input type="submit" value="<?php _e('Go', 'largo'); ?>" name="search submit" class="search-submit btn">
	</div>
</form>
