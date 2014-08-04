<?php
/**
 * Home Template: Single
 * Description: Prominently features the top story by itself
 * Sidebars: Home Bottom Left | Home Bottom Center | Home Bottom Right
 * Right Rail: none
 */

?>
<div id="homepage-featured" class="row-fluid clearfix">
	<div class="home-single span12">
		<?php echo $zoneOne; ?>
		<div class="home-top">
		<?php echo $zoneTwo; ?>
		<?php if (!empty($zoneThree)) { ?>
			<div><h2><?php echo $zoneThree; ?></h3></div>
		<?php } ?>
		</div>
	</div>
</div>
