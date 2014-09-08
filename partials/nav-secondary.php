<?php

if ( of_get_option( 'show_dont_miss_menu') ) { ?>
	<nav id="secondary-nav" class="clearfix">
		<div id="topics-bar" class="span12 hidden-phone">
			<?php largo_cached_nav_menu( array( 'theme_location' => 'dont-miss', 'container' => false, 'depth' => 1 ) ); ?>
		</div>
	</nav>
<?php }
