<!-- Header -->
<div id="sns_header" class="wrap <?php echo esc_attr(dsk_getoption('header_style', 'style1')); ?>">
	<div class="main-header container">
		<div class="row">
			<div class="header-left col-lg-10 col-xs-8 col-phone-6">
				<div class="header-logo pull-left">
					<div id="logo">
						<?php $logourl = dsk_getoption('header_logo', DSK_THEME_URI.'/assets/img/logo.png', 'image'); ?>
						<a class="logo-retina" href="<?php echo esc_url( home_url('/') ) ?>" title="<?php bloginfo( 'sitename' ); ?>">
							<img src="<?php echo esc_attr($logourl); ?>" alt="<?php bloginfo( 'sitename' ); ?>"/>
						</a>
					</div>		
				</div>
				<div id="sns_mainmenu" class="visible-lg pull-left">
					<?php
		                if(has_nav_menu('main_navigation')):
				           wp_nav_menu( array(
				           				'theme_location' => 'main_navigation',
				           				'container' => false, 
				           				'menu_id' => 'main_navigation',
				           				'walker' => new dsk_Megamenu_Front,
				           				'menu_class' => 'nav navbar-nav'
				           	) ); 
						else:
							echo '<p class="hidden main_navigation_alert">'.esc_html__('Please sellect menu for Categories navigation', 'dsk').'</p>';
						endif;
					?>
				</div>
			</div>
			<div class="header-right col-lg-2 col-xs-4 col-phone-6"><div class="inner">
				<div class="mini-search">
					<span class="tongle"></span>
				</div>
				<?php
				if ( class_exists('WooCommerce') ) : ?>
					<?php
					if ( function_exists('YITH_WCWL') ) { ?>
					<div class="mini-wishlist hidden-xs">
						<a class="tongle" href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>">
							<span class="number"><?php echo YITH_WCWL()->count_products(); ?></span>						
						</a>
					</div>
					<?php
					}?>
					<div class="mini-cart sns-ajaxcart">
						<a href="<?php echo wc_get_cart_url(); ?>" class="tongle">
							<span class="cart-label"><?php echo esc_html__("Cart", "dsk"); ?></span>
							<span class="number"><?php echo sizeof( WC()->cart->get_cart() );?></span>
						</a>
						<?php if ( !is_cart() && !is_checkout() ) : ?>
							<div class="content">
								<div class="cart-title"><h4><?php echo esc_html__("My cart", "dsk"); ?></h4></div>
								<div class="block-inner">
									<?php the_widget( 'WC_Widget_Cart', 'title= ', array('before_title' => '', 'after_title' => '') ); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<!-- Main menu wrap -->
				<div class="menu-sidebar hidden-lg">
					<span class="tongle"></span><span class="overlay"></span>
					<div class="sidebar-content">
						<?php
						$tms_wcode = new WP_Query(array( 'name' => 'top-menu-sidebar', 'post_type' => 'post-wcode' ));
					    if ($tms_wcode->have_posts()) { ?>
					    	<div class="top-menu-sidebar">
					    	<?php echo do_shortcode('[dsk_postwcode name="top-menu-sidebar"]'); ?>
					    	</div>
					    	<?php
					    } ?>
						<div class="mid-menu-sidebar">
	                    <?php
	                    if(has_nav_menu('main_navigation')):
		                   $main_menu = '';
							if(is_page() && ($menu_selected = get_post_meta(get_the_ID(), 'dsk_main_menu', true))){
								$main_menu = $menu_selected;
							}
	                   		wp_nav_menu( array(
				           				'theme_location' => 'main_navigation',
				           				'container' => false,
				           				'menu'		=> $main_menu,
				           				'menu_id' => 'main_menu_sidebar',
				           				'menu_class' => 'nav-sidebar resp-nav'
				           	) );
	                    else:
	                        echo '<p class="hidden main_navigation_alert">'.esc_html__('Please sellect menu for Main navigation', 'dsk').'</p>';
	                    endif;
	                    ?>
	                	</div>
	                	<?php 
	                	$bms_wcode = new WP_Query(array( 'name' => 'bottom-menu-sidebar', 'post_type' => 'post-wcode' ));
					    if ($bms_wcode->have_posts()) { ?>
					    	<div class="bottom-menu-sidebar">
					    	<?php echo do_shortcode('[dsk_postwcode name="bottom-menu-sidebar"]'); ?>
					    	</div>
					    	<?php
					    } ?>
	                </div>
                </div>
                <div class="btn-navbar leftsidebar">
				    <span class="overlay"></span>
				</div>
				<div class="btn-navbar rightsidebar">
				    <span class="overlay"></span>
				</div>
			</div></div>
		</div>
	</div>
	<div class="search-box">
		<?php
		if ( dsk_getoption('enable_search_cat') == true ) dsk_get_searchform('def');
		else dsk_get_searchform('hide_cat');
		?>
	</div>
</div>
<?php dsk_slideshow_wrap(); ?>
<?php 
do_action('dsk_before_sns_content');

