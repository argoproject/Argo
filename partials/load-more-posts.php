<nav id="<?php echo $nav_id; ?>" class="pager post-nav">
	<div class="load-more">
		<?php next_posts_link( apply_filters('largo_next_posts_link', __('Load more ', 'largo') . strtolower($posts_term)) ); ?>
	</div>
	<?php largo_load_more_posts_data($nav_id, $the_query); ?>
</nav>
