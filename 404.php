<?php
/**
 * The template for displaying 404 pages.
**/
get_header(); ?>

<div id="content" class="span8" role="main">
	<?php get_template_part( 'content', 'not-found' ); ?>
</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="span4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>