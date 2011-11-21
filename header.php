<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */
?><!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . 'Page ' . max( $paged, $page );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	wp_enqueue_style( 'argo-stylesheet', get_bloginfo( 'stylesheet_url' ) );
	wp_enqueue_script( 'argo-modernizr', get_template_directory_uri() . '/js/modernizr.custom.55609.js' );

	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<?php get_template_part('customstyle');?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
   
   <div class="global-nav-bg"> 
		<div class="global-nav">
			<nav>
        		<span class="visuallyhidden">
        			<a href="#main" title="Skip to content">Skip to content</a>
        		</span>
        		<?php wp_nav_menu( array( 'theme_location' => 'global-nav', 'container' => false, 'depth' => 1 ) ); ?>
        	</nav>
        </div>
       <!-- /.global-nav -->
	</div> <!-- /.global-nav-bg -->

	<div id="header"><header>
	
	<div class="container_12 clearfix">
			<?php
				$header_image = get_header_image();
				// Has the text been hidden?
				if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor()):
					$style = ' style="display:none;"';
			?>
				<div id="branding" class="grid_6">
			<?php 
				// Has the header image been hidden?
				elseif (empty( $header_image )):
			?>
				<div id="branding" class="grid_6">
			<?php
				else :
				$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
			?>
				<div id="branding" class="grid_6 brand-image">
			<?php endif; ?>
			
			    <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'h2'; ?>
				<<?php echo $heading_tag; ?> id="site-title" <?php echo $style; ?>>
        		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            	<?php bloginfo('name'); ?>
        		</a>
    		</<?php echo $heading_tag; ?>>
    		<h2 id="site-description" <?php echo $style; ?>><?php bloginfo('description'); ?></h2>
    		
			<?php
				// Check to see if the header image has been removed
				$header_image = get_header_image();
				if ( ! empty( $header_image ) ) :
			?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="<?php bloginfo('name'); ?>">
				</a>
				
			<?php endif; // end check for removed header image ?>
			
		</div><!-- end .grid_6 -->
		<div class="grid_6 featured-posts">
            <?php $featured = argo_get_featured_posts(); 
                  $slot = 1;
                  while ( $featured->have_posts() ) : $featured->the_post(); ?>

                <div id="feature<?php echo $slot; ?>" class="features">
                    <a href="<?php the_permalink(); ?>" title="headline">
                        <?php the_post_thumbnail(); ?></a>
                    <h3 class="features-caption unitPng"><a href="<?php the_permalink(); ?>" title="headline"><?php the_title(); ?></a></h3>
                </div>

            <?php $slot++;
            endwhile; ?>		
		</div> <!-- end .grid_6 -->
		
	</div> <!--/ .container_12 -->

	</header></div>
<!-- ============= / #header  ============= -->
	<div id="main-nav">
		<nav>
        <?php wp_nav_menu( array( 'theme_location' => 'categories', 'container' => false , 'menu_id' => 'topnav', 'walker' => new Argo_Categories_Walker, 'depth' => 1 ) ); ?>
		</nav><!-- /#main-nav -->
		<nav id="utility-nav">
			<div id="header-search">
				<?php get_search_form(); ?>
			</div>
			
            <ul id="follow-us">
                <?php if ( get_option( 'facebook_link' ) ) : ?>
                <li class="icon-fb-header"><a href="<?php echo get_option( 'facebook_link' ); ?>" title="Facebook">Facebook</a></li>
                <?php endif; ?>
                <?php if ( get_option( 'twitter_link' ) ) : ?>
                <li class="icon-twitter-header"><a href="<?php echo get_option( 'twitter_link' ); ?>" title="Twitter">Twitter</a></li>
                <?php endif; ?>
            </ul> <!-- /#follow-us -->
            
        </nav> <!-- /utility-nav -->
    </div> <!-- /main-nav -->
    <div id="secondary-nav" class="container_12 clearfix">
    	<nav>
    		<div id="topics-bar" class="grid_12">
				<?php wp_nav_menu( array( 'theme_location' => 'dont-miss', 'container' => false, 'depth' => 1 ) ); ?>
			</div> <!--/.grid_12-->
		</nav>
	</div><!--/.container_12-->
 
	<div id="main" class="container_12 clearfix">