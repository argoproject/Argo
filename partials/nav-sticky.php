<div class="sticky-nav-wrapper">
	<div class="sticky-nav-holder <?php echo (is_front_page() || is_home()) ? '' : 'show'; ?>" data-hide-at-top="<?php echo (is_front_page() || is_home()) ? 'true' : 'false'; ?>"><div class="sticky-nav-container">
		<nav id="sticky-nav" class="sticky-navbar navbar clearfix">
		<div class="container">
			<div class="nav-right">
				<?php if ( of_get_option( 'show_header_social') ) { ?>
					<ul id="header-social" class="social-icons visible-desktop">
						<?php largo_social_links(); ?>
					</ul>
				<?php } ?>

				<?php if ( of_get_option( 'show_donate_button') )
					largo_donate_button();
				?>

					<div id="header-search">
						<form class="form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<i class="icon-search toggle" title="<?php esc_attr_e('Search', 'largo'); ?>" role="button"></i>
							<div class="input-append">
								<span class="text-input-wrapper"><input type="text" placeholder="<?php esc_attr_e('Search', 'largo'); ?>" class="input-medium appendedInputButton search-query" value="" name="s" /></span><button type="submit" class="search-submit btn"><?php _e('GO', 'largo'); ?></button>
							</div>
						</form>
					</div>
				</div>

		  <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
		  <a class="btn btn-navbar toggle-nav-bar" title="<?php esc_attr_e('More', 'largo'); ?>">
			<div class="bars">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</div>
		  </a>

		  <ul class="nav">
			<li class="home-link"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php largo_home_icon( 'icon-white' ); ?></a></li>
			<li class="divider-vertical"></li>
				</ul>

		  <div class="nav-shelf">
					<ul class="nav"><?php
						$args = array(
							'theme_location' => 'main-nav',
							'depth'		 => 0,
							'container'	 => false,
							'items_wrap' => '%3$s',
							'menu_class' => 'nav',
							'walker'	 => new Bootstrap_Walker_Nav_Menu()
						);
						largo_cached_nav_menu($args);

						if (has_nav_menu('global-nav')) {
						?>
						<li class="menu-item-has-childen dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle"><?php
									//try to get the menu name from global-nav
									$menus = get_nav_menu_locations();
									$menu_title = wp_get_nav_menu_object($menus['global-nav'])->name;
									echo ( $menu_title ) ? $menu_title : __('About', 'largo');
								?> <b class="caret"></b>
							</a>
							<?php
								$args = array(
									'theme_location' => 'global-nav',
									'depth'		 => 1,
									'container'	 => false,
									'menu_class' => 'dropdown-menu',
								);
								largo_cached_nav_menu($args);
							?>
						</li>
						<?php } ?>
					</ul>
				</div>
		</div>
		</nav>
	</div></div>
</div>
