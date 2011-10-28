<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<div class="post-meta top-meta">
				<ul class="meta-gestures clearfix">
        			<li><?php argo_posted_on(); ?></li>
    				<li class="meta-comments"><span class="comments-link"><?php comments_popup_link( 'Comment', '<strong>1</strong> Comment ', ' <strong>%</strong> Comments' ); ?></span></li>
    			</ul>
    		</div><!-- /.post-meta -->
 		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- / entry header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<div class="post-meta bottom-meta">
            
            <?php if ( argo_has_custom_taxonomy(get_the_ID()) ): ?>
				<ul class="labels clearfix">
					<li id="term-view">View more:</li>
            		<?php argo_the_post_labels( get_the_ID() ); ?>
        		</ul>
        	<?php endif; ?> 
        	
        <?php if ( argo_has_categories_or_tags() ): ?>
    		<h5>Filed under: <?php echo argo_the_categories_and_tags(); ?></h5>
    	<?php endif; ?>
          
            </div><!-- /.post-meta -->
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
