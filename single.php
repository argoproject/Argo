<?php
/**
 * The Template for displaying all single posts.
 */
if ( of_get_option( 'single_template' ) == 'classic' )
	locate_template( 'single-two-column.php', true );
else
	locate_template( 'single-one-column.php', true );
