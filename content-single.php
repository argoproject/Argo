<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="http://schema.org/Article">
	<?php do_action('largo_before_post_header'); ?>
	<header>
 		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
 		<?php if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) )
 			echo '<h2 class="subtitle">' . $subtitle . '</h2>';
 		?>
 		<h5 class="byline"><?php largo_byline(); ?></h5>

 		<meta itemprop="description" content="<?php echo strip_tags(largo_excerpt( $post, 5, false, '', false ) ); ?>" />
 		<meta itemprop="datePublished" content="<?php echo get_the_date( 'c' ); ?>" />
 		<meta itemprop="dateModified" content="<?php echo get_the_modified_date( 'c' ); ?>" />
 		<?php
 			if ( has_post_thumbnail( $post->ID ) ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
				echo '<meta itemprop="image" content="' . $image[0] . '" />';
			}
 		?>
	</header><!-- / entry header -->

	<?php
		$values = get_post_custom( get_the_id() );
		$youtube_url = isset( $values['youtube_url'] ) ? esc_attr( $values['youtube_url'][0] ) : '';

		$hero_class = "is-image";
		if ( $youtube_url ) {
			$hero_class = "is-video";
		} else if ( !has_post_thumbnail() ) {
			$hero_class = "is-empty";
		}
	?>

	<?php if ( !isset( $values["featured-image-display"] ) ) : ?>
	<div class="hero span12 <?php echo $hero_class; ?>">
		<?php
			if( $youtube_url ){

				// get embed ID
				parse_str( parse_url( $youtube_url, PHP_URL_QUERY ), $var_array );
				$youtubeID = $var_array['v'];

				?>
					<div class="video-container">
						<iframe  src="//www.youtube.com/embed/<?php echo $youtubeID ?>" frameborder="0" allowfullscreen></iframe>
					</div>
				<?php
			} elseif( has_post_thumbnail() ){
				the_post_thumbnail( 'full');
				if ( $thumb = get_post_thumbnail_id() ) {
					$thumb_content = get_post( $thumb );
					$thumb_custom = get_post_custom( $thumb );
					if ( isset($thumb_custom['_media_credit'][0]) ) {
						echo '<p class="wp-media-credit">' . $thumb_custom['_media_credit'][0];
						if ( $thumb_custom['_navis_media_credit_org'][0] ) {
							echo '/' . $thumb_custom['_navis_media_credit_org'][0];
						}
						echo '</p>';
					}
					if ( $thumb_content->post_excerpt ) {
						echo '<p class="wp-caption-text">' . $thumb_content->post_excerpt . '</p>';
					}
				}
			}
		?>
	</div>
	<?php endif; ?>

	<?php do_action('largo_after_post_header'); ?>

	<?php get_sidebar(); ?>

	<div class="entry-content clearfix" itemprop="articleBody">
		<?php largo_entry_content( $post ); ?>
	</div><!-- .entry-content -->
	<?php do_action('largo_after_post_content'); ?>
	<?php do_action('largo_after_post_footer'); ?>
</article><!-- #post-<?php the_ID(); ?> -->