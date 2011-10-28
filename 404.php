<!DOCTYPE html>
<html>
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title>Page Not Found</title>
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=1" />
	</head>
	<body>
	<div id="wrapper">
		<div class="global-nav-bg">
	<div class="global-nav"> 
	</div><!-- /.global-nav -->
    </div> <!-- /.global-nav-bg -->
    
    <div id="header">
    <div class="container_12 clearfix">
        <div class="grid_6 branding">
    		<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'h2'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
        		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="unitPng">
            	<?php bloginfo('name'); ?>
        		</a>
    		</<?php echo $heading_tag; ?>>
    		<h2><?php bloginfo('description'); ?></h2>
		</div>
        <!-- end .grid_6 -->
	</div> <!--/ .container_12 -->
	</div> <!-- /header -->
	
	<div id="main" class="container_12 clearfix">
	<div id="content" class="grid_12 search-404">
	<h1 class="entry-title">Not Found</h1>
<p>Sorry. We can't find the page you were looking for. Please try searching for related posts:</p>
<?php get_search_form(); ?>
	</div><!-- /content -->
	</div><!-- /main -->
	</div><!-- /wrapper -->
	
	</body>
</html>
