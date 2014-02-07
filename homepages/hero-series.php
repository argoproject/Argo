<?php
/**
 * Home Template: Hero with Series
 * Description: Prominently features the top story along with other posts in its series
 * Sidebars: Home Bottom Left | Home Bottom Center | Home Bottom Right
 * Right Rail: none
 */

global $largo, $shown_ids, $tags;

?>
<div id="homepage-featured" class="row-fluid clearfix">
	<div class="hero-series span12">
		<aside id="view-format">
			<?php // @todo Make this check the cookie server-side ?>
			<h1><?php _e('View', 'largo'); ?></h1>
			<ul>
				<li><a href="#" class="active" data-style="top">Top Stories</a></li>
				<li><a href="#" data-style="list">List</a></li>
		</aside>

		<div class="home-top">
	<?php

		$post_states = largo_home_series_states();
		extract( $post_states ); // $big_story, $side_stories, $side_stories_display


		if( $has_video = get_post_meta( $big_story->ID, 'youtube_url', true ) ): ?>
			<div class="embed-container max-wide">
				<iframe src="http://www.youtube.com/embed/<?php echo substr(strrchr( $has_video, "="), 1 ); ?>?modestbranding=1" frameborder="0" allowfullscreen></iframe>
			</div>
		<?php else: ?>
			<div class="full-hero max-wide"><a href="<?php echo esc_attr( get_permalink( $big_story->ID ) ); ?>"><?php echo get_the_post_thumbnail( $big_story->ID, 'full' ); ?></a></div>
		<?php endif; ?>

		<div id="dark-top" <?php echo (!$has_video) ? 'class="overlay"' : ''; ?>>
			<div class="span10">
				<div class="row-fluid">
					<article class="<?php echo ($side_stories_display == 'hide') ? '' : 'span8'; ?>">
						<h5 class="top-tag"><?php largo_top_term( array('post'=>$big_story->ID) ); ?></h5>
						<h2><a href="<?php echo esc_attr( get_permalink( $big_story->ID ) ); ?>"><?php echo get_the_title( $big_story->ID ); ?></a></h2>
						<h5 class="byline"><?php _e('By'); ?> <?php largo_author_link( true, $big_story ); ?></h5>
						<section>
							<?php largo_excerpt( $big_story, 2, false ); ?>
						</section>
					</article>
					<?php if ( $side_stories_display != 'hide' ): ?>
					<div class="span4 <?php echo $side_stories_display == 'series' ? 'side-series' : 'side-articles'; ?>">
						<?php if ( $side_stories_display == 'series' && !empty($side_stories_term) ): ?>
							<h3><a href="<?php echo get_term_link( $side_stories_term ); ?>"><?php echo esc_html( $side_stories_term->name ); ?></a></h3>
						<?php endif; ?>

						<?php foreach ( $side_stories as $side_story ): ?>
						<article>
							<?php if ( $side_stories_display == 'articles' ): ?>
								<h5 class="top-tag"><?php largo_top_term( array( 'post' => $side_story->ID ) ); ?></h5>
							<?php endif; ?>
							<h4><a href="<?php echo get_permalink( $side_story->ID ); ?>"><?php echo get_the_title( $side_story->ID ); ?></a></h4>
							<?php if ( $side_stories_display == 'articles' ): ?>
								<h5 class="byline"><?php _e('By'); ?> <?php largo_author_link( true, $side_story ); ?></h5>
							<?php endif; ?>
						</article>
						<?php endforeach; ?>

						<?php if ( $side_stories_display == 'series' && !empty($side_stories_term) ): ?>
							<div class="read-more"><a href="<?php echo get_term_link( $side_stories_term ); ?>"><?php _e( 'Complete Coverage >', 'largo'); ?></a></div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="home-secondary" class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span4">
				<?php dynamic_sidebar('home-bottom-left'); ?>
			</div>
			<div class="span4">
				<?php dynamic_sidebar('home-bottom-center'); ?>
			</div>
			<div class="span4">
				<?php dynamic_sidebar('home-bottom-right'); ?>
			</div>
		</div>
	</div>
</div>

<?php // The "river" content view ?>
<div id="home-river" class="row-fluid">
	<div class="span10 offset1">
	<h1><?php _e( 'Latest Stories', 'largo' ); ?></h1>

	<?php
			//start at the beginning of the list
			rewind_posts();

			while ( have_posts() ) : the_post();
				get_template_part( 'content', 'home' );
			endwhile;

			largo_content_nav( 'nav-below' );
	?>
	</div>
</div>