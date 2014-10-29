<?php
// Using is_front_page() instead of is_home() in case static page is used
if (is_front_page() && is_active_sidebar('homepage-alert')) { ?>
<div class="alert-wrapper max-wide">
	<div id="alert-container">
		<?php dynamic_sidebar('homepage-alert'); ?>
	</div>
</div>
<?php } ?>
