<?php
/**
 * The template for displaying search forms
 */
?>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div>
			<input type="text" placeholder="SEARCH" class="searchbox" value="" name="s" />
			<input type="submit" value="GO" name="search submit" class="search-submit">
		</div>
	</form>
