<?php
/**
 * The Template for displaying all single posts.
 */
if ( of_get_option( 'single_template' ) == 'classic' )
	include_once __DIR__ . '/single-two-column.php';
else
	include_once __DIR__ . '/single-one-column.php';
