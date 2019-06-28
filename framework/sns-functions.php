<?php
/*
 * Get theme option
 */
function dsk_themeoption($option, $default = '', $key = ''){
	global $dsk_opt;
	$value = '';
	// Get config via theme option
	if($key !== ''){
		if ( isset($dsk_opt[$option][$key]) && $dsk_opt[$option][$key] ) $value = $dsk_opt[$option][$key];
	}else{
		if ( isset($dsk_opt[$option]) && $dsk_opt[$option] ) $value = $dsk_opt[$option];
	}
	// Get config via cookie
	if ( isset($_COOKIE['dsk_'.$option]) && $_COOKIE['dsk_'.$option] != '' ) {
		$value = $_COOKIE['dsk_'.$option];
	}
	// Return value when exists ReduxFramework
	if($value || class_exists( 'ReduxFramework' ))
		return $value; 
	// Return default value
	return $default;
}
/*
 * Set theme option
 */
function dsk_set_themeoption($key, $value){
	global $dsk_opt;
	if ( $key != '' && $value != '' )
		$dsk_opt[$key] = $value;
}
/*
 * Get theme & post/page option
 */
function dsk_getoption($option, $default = '', $type = null){
	global $post;
    $value = ''; $value1 = '';
    $value = dsk_themeoption($option, $default);
    if ( $type == 'image' && is_array($value) ){
    	if ( $value['url'] == '' ) {
    		$value = $default;
    	}else{
    		$value = $value['url'];
    	}
    }
    // Get config via page/product config
    if ( function_exists('rwmb_meta') ){
    	// Just page/product have rwmb_meta 
    	if( class_exists('WooCommerce') && is_woocommerce() || is_page() ){
    		$value1 = rwmb_meta('dsk_'.$option);
	    	if ( ( !is_array($value1) && trim($value1) == '' ) || ( is_array($value1) && empty($value1) ) ) {
	    		if ( class_exists('WooCommerce') ) {
		    		if ( is_product() ){
		    			$value1 = rwmb_meta('dsk_'.$option, array(), $post->ID);
		    		}elseif( is_shop() ) { // for shop page
		    			$value1 = rwmb_meta('dsk_'.$option, array(), get_option('woocommerce_shop_page_id'));
		    		}
		    	}
	    	}else{
	    		if ( $type == 'image' ){
			    	foreach ( $value1 as $img ) {
			    		$value1 = $img['full_url'];
			    	}
			    }
	    	}
    	}
	}
	if ( ( ( !is_array($value1) && trim($value1) == '' ) || ( is_array($value1) && empty($value1) )  ) && $default ) {
		if ( $value != '' ) {
			return $value;
		}else{
			return $default;
		}
	}
    if ( $value1 != '' ) return $value1;
    if ( $value != '' ) return $value;
	return $default;
}
/*
 * Get theme & post/page option
 */
function dsk_woo_cat_option($option, $default = '', $type = null){
    $value = ''; $value1 = '';
    $value = dsk_themeoption($option, $default);
    if ( $type == 'image' ){
    	if ( isset($value['url']) ){
    		if ($value['url'] == '' ) {
	    		$value = $default;
	    	}else{
	    		$value = $value['url'];
	    	}
	    }
    }
    if( class_exists('WooCommerce') && is_woocommerce() && is_product_category() ){
        $cate = get_queried_object();
        $value1 = dsk_get_term_byid( $cate->term_id, 'dsk_'.$option );
    }
    //if ( ( ( !is_array($value1) && trim($value1) == '' ) || ( is_array($value1) && empty($value1) )  ) && $default ) {
    if ( trim($value1) == '' ) {
		if ( $value != '' ) {
			return $value;
		}else{
			return $default;
		}
	}
    if ( $value1 != '' ) return $value1;
    if ( $value != '' ) return $value;
	return $default;
}
/*
 * Get meta box data
 */
function dsk_metabox($field_id, $args = array()){
	if( !function_exists('rwmb_meta') ){
		return '';
	}
	$field_id = 'dsk_'.$field_id;
	if( function_exists('is_shop') && is_shop() ) {
		return rwmb_meta($field_id, $args, get_option('woocommerce_shop_page_id'));
	}
	return rwmb_meta($field_id, $args);
}
function dsk_get_term_byid($term_id, $key, $default = ''){
	$value = get_term_meta( $term_id, $key );
    $value = ( is_array($value) && isset($value[0]) && $value[0] != '' ) ? $value[0] : $default; //var_dump($key.': '.$value. ' & default: '.$default);
    return $value;
}
/*
 * Css file
 */
function dsk_css_file(){
	$compile_obj = new DSKCompileSass();
	$optimize = '';
	$theme_color = dsk_getoption('theme_color', '#dba87f');
	// Get page meta data
	if ( is_page() && function_exists('rwmb_meta') && rwmb_meta('dsk_page_themecolor') == 1) {
		$theme_color = rwmb_meta('dsk_theme_color') != '' ? rwmb_meta('dsk_theme_color') : $theme_color;
	}
	$body_color = dsk_themeoption('body_font', '#777777', 'color');
	$scss_compile = dsk_themeoption('advance_scss_compile', '1');
	$scss_format = dsk_themeoption('advance_scss_format', 'scss_formatter_compressed');
	// Compile scss and get css file name
	$css_file = $compile_obj->dsk_getstyle(
		$scss_compile,
		array('dir' => DSK_THEME_DIR . '/assets/scss/', 'name' => 'theme'),
		array('dir' => DSK_THEME_DIR . '/assets/css/', 'name' => 'theme'),
		$scss_format,
		array(
			'$color1' => $theme_color,
			'$color' => $body_color,
		)
	);
	return $css_file;
}
/**
 * Layout type
**/
function dsk_layouttype($option='layouttype', $default=''){
	$layouttype = dsk_getoption($option, $default);
	if( class_exists('WooCommerce') && is_woocommerce() ){
		$layouttype = dsk_metabox('dsk_layouttype', $default);
		if( is_product_category() ){
			$cate = get_queried_object();
			$layouttype = dsk_get_term_byid($cate->term_id, 'dsk_product_cat_layout', 'l-m');
		}
		if ( trim($layouttype) == '' ) $layouttype = 'l-m';
		if( is_product_tag() ){
			$layouttype = 'l-m';
		}
		if( is_product() ){ 
			if ( dsk_getoption('single_product_sidebar') == 1 ) {
				$layouttype = 'm-r';
			}else{
				$layouttype = 'm';
			}
		}
	}
	if ( trim($layouttype) == '' ) $layouttype = 'm-r';
	return $layouttype;
}
/**
 * Left Column
**/
function dsk_leftcol(){
	$layouttype = dsk_layouttype('layouttype', 'm-r');
	if ( $layouttype == '' || $layouttype == 'm-r' || $layouttype == 'm' ) 
		return '';
	?>
	<div class="col-md-3 sns-left">
		<?php
	    if( class_exists('WooCommerce') && is_woocommerce() ){
	        if( is_product() ){
	    		dynamic_sidebar('product-sidebar');
	    	}else{
	        	if( is_active_sidebar( 'woo-sidebar' ) ) {
		        	dynamic_sidebar( 'woo-sidebar' ); 
		        }else{
		        	dynamic_sidebar('widget-area');
		        }
	        }
	    }else{
	        if( dsk_getoption('leftsidebar') != '' && is_active_sidebar( dsk_getoption('leftsidebar') ) ) {
	        	dynamic_sidebar( dsk_getoption('leftsidebar') ); 
	        }else{
	        	dynamic_sidebar('widget-area');
	        }
	    } ?>
	</div>
	<?php
 }
/**
 * Right Column
**/
 function dsk_rightcol(){
 	$layouttype = dsk_layouttype('layouttype', 'm-r');
	if ( $layouttype == '' || $layouttype == 'l-m' || $layouttype == 'm' ) 
		return '';
	?>
	<div class="col-md-3 sns-right">
		<?php
	    if( class_exists('WooCommerce') && is_woocommerce() ){
	    	if( is_product() ){
	    		dynamic_sidebar('product-sidebar');
	    	}else{
	        	if( is_active_sidebar( 'woo-sidebar' ) ) {
		        	dynamic_sidebar( 'woo-sidebar' ); 
		        }else{
		        	dynamic_sidebar('widget-area');
		        }
	        }
	    }else{
	        if( dsk_getoption('rightsidebar') != '' && is_active_sidebar( dsk_getoption('rightsidebar') ) ) {
	        	dynamic_sidebar( dsk_getoption('rightsidebar') ); 
	        }else{
	        	dynamic_sidebar('widget-area');
	        }
	    } ?>
	</div>
	<?php
 }
/**
 * Main class
**/
function dsk_maincolclass(){
	$layouttype = dsk_layouttype('layouttype', 'm-r');
	$mclass = 'sns-main';
	if ( $layouttype == 'l-m' ) {
		$mclass .= ' col-md-9 main-left';
	}elseif( $layouttype == 'm-r' ){
		$mclass .= ' col-md-9 main-right';
	}elseif ( $layouttype == 'l-m-r' ) {
		$mclass .= ' col-md-6 main-center';
	}else{
		$mclass .= ' col-md-12';
	}
	return $mclass;
}
/**
 * Return number of published sticky posts
**/
function dsk_get_sticky_posts_count(){
	global $wpdb;
	$sticky_posts = array_map('absint', (array)get_option('sticky_posts') );
	return count($sticky_posts) > 0 ? $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( 1 ) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND ID IN (".implode(',', $sticky_posts).")" ) ) : 0;
}

/**
 * Display Ajax loading
 */
function dsk_paging_nav_ajax( $content_div = '#snsmain', $template = '' ){
	// Don't print empty markup if there is only one page.
	if( $GLOBALS['wp_query']->max_num_pages < 2 ){
		return;
	}
	$label1 = esc_html__('Load more', 'dsk');
	$label2 = esc_html__('Loading', 'dsk');
	if ( dsk_themeoption('pagination') == 'ajax2' ){
		$class = 'load-more auto-load';
		$label1 = $label2;
	}else{
		$class = 'load-more click-load';
	}
	?>
	<nav class="navigation-ajax" role="navigation">
		<a href="<?php echo esc_url('javascript:void(0)'); ?>" 
			data-target="<?php echo esc_attr($content_div);?>" 
			data-template="<?php echo esc_attr($template); ?>" 
			data-numload="<?php echo esc_attr(dsk_themeoption('masonry_numload', 3))?>" 
			data-label="<?php echo esc_attr($label1); ?>"
			data-labelload="<?php echo esc_attr($label2); ?>"
			id="navigation-ajax" 
			class="<?php echo esc_attr($class); ?>">
			<?php echo esc_html($label1); ?>
		</a>
	</nav>
	<?php
}
/*
 * Ajax page navigation
 */
function dsk_ajax_load_next_page(){
	// Get current layout
	global $dsk_blog_layout;
	$dsk_blog_layout = isset($_POST['dsk_blog_layout']) ? esc_html($_POST['dsk_blog_layout']) : '';
	if( $dsk_blog_layout == '' ) $dsk_blog_layout = dsk_getoption('blog_type');
	// Get current page
	$page = $_POST['page'];
	// Number of published sticky posts
	$sticky_posts = dsk_get_sticky_posts_count();
	// Current query vars
	$vars = $_POST['vars'];
	// Convert string value into corresponding data types
	foreach ($vars as $key => $value){
		if( is_numeric($value) ) $vars[$key] = intval($value);
		if( $value == 'false' ) $vars[$key] = false;
		if( $value == 'true' ) $vars[$key] = true;
	}
	// Item template file 
	$template = $_POST['template'];
	// Return next page
	$page = intval($page) + 1;
	$posts_per_page = $_POST['numload'];
    if( $page == 2 && $vars['posts_per_page'] ){
        $offset = $vars['posts_per_page'];
    }else{
        $offset = $vars['posts_per_page'] + ($page - 2) * $posts_per_page;
    }
	// Get more posts per page than necessary to detect if there are more posts
	$args = array('post_status'=>'publish', 'posts_per_page'=>$posts_per_page + 1, 'offset'=>$offset);
	$args = array_merge($vars, $args);
	// Remove unnecessary variables
	unset($args['paged']);
	unset($args['p']);
	unset($args['page']);
	unset($args['pagename']); // This is necessary in case Posts Page is set to static page
	$query = new WP_Query($args);
	$idx = 0;
	if( $query->have_posts() ){
		while ( $query->have_posts() ){
			$query->the_post();
			$idx = $idx + 1;
			if( $idx < $posts_per_page + 1 )
				get_template_part($template, get_post_format());
		}
		if( $query->post_count <= $posts_per_page ){
			// There are no more posts
			// Print a flag to detect
			echo '<div id="sns-load-more-no-posts" class="no-posts"><!-- --></div>';
		}
	}else{
		// No posts found
	}
	/* Restore original Post Data*/
	wp_reset_postdata();
	die('');
}
// When the request action is "load_more", the dsk_ajax_load_next_page() will be called
add_action('wp_ajax_load_more', 'dsk_ajax_load_next_page');
add_action('wp_ajax_nopriv_load_more', 'dsk_ajax_load_next_page');

function remove_img_attr ($html)
{
    return preg_replace('/(sizes|width|height)="\d+"\s/', "", $html);
}
 

/**
 * Display navigation to next/previous post when applicable.
 */
function dsk_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}?>
	<div class="post-standard-navigation post-navigation" role="navigation">
    	<?php 
    	if( $previous ):
    		$img_p = get_the_post_thumbnail_url( $previous->ID, 'dsk_blog_large_thumb'); ?>
        <div class="nav-previous<?php echo (esc_attr($img_p))?' have-thumb':''; ?>" data-thumb="<?php echo esc_attr($img_p); ?>">
            <div class="area-content">
            	<?php
            	previous_post_link('%link',''); // link overlay
                ?>
                <div class="nav-content">
                	<?php 
                		previous_post_link( '<div class="nav-post-link">%link</div>', _x( 'Prev post', 'Previous post link', 'dsk' ) );
						previous_post_link( '<div class="nav-post-title second-font">%link</div>');
					?>	
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if( $next ): 
        	$img_n = get_the_post_thumbnail_url( $next->ID, 'dsk_blog_large_thumb'); ?>
        <div class="nav-next<?php echo (esc_attr($img_n))?' have-thumb':''; ?>" data-thumb="<?php echo esc_attr($img_n); ?>">
            <div class="area-content ">
            	<?php
            	next_post_link( '%link',''); // link overlay
                ?>
                <div class="nav-content">
                	<?php 
                		next_post_link( '<div class="nav-post-link">%link</div>', _x( 'Next post', 'Next post link', 'dsk' ) );
						next_post_link( '<div class="nav-post-title second-font">%link</div>');
					?>
                </div>
            </div>
        </div>
        <?php endif; ?>
	</div>
	<?php
}

if ( dsk_themeoption('advance_cpanel', 0) == 1 ){
	// Set cookie theme option
	add_action( 'wp_ajax_sns_setcookies', 'dsk_setcookies' );
	add_action( 'wp_ajax_nopriv_sns_setcookies', 'dsk_setcookies' );
	// Reset cookie theme option
	add_action( 'wp_ajax_sns_resetcookies', 'dsk_resetcookies' );
	add_action( 'wp_ajax_nopriv_sns_resetcookies', 'dsk_resetcookies' );
	function dsk_setcookies(){
		setcookie('dsk_'.$_POST['key'], $_POST['value'], time()+3600*24*1, '/'); // 1 day
	}
	function dsk_resetcookies(){
		setcookie('dsk_advance_scss_compile', '', 0, '/');
		setcookie('dsk_use_stickmenu', '', 0, '/');
	}
}