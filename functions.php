<?php
define( 'DSK_THEME_DIR', get_template_directory() );
define( 'DSK_THEME_URI', get_template_directory_uri() );
require_once( DSK_THEME_DIR.'/framework/init.php' );
/** 
 *   Initialize Visual Composer in the theme.
 **/
add_action( 'vc_before_init', 'dsk_vc_setastheme' );
function dsk_vc_setastheme() {
    if ( function_exists('vc_set_as_theme') ) vc_set_as_theme(true);
}
/** 
 *  Width of content, it's max width of content without sidebar.
 **/
if ( ! isset( $content_width ) ) { $content_width = 660; }

/** 
 *  Set base function for theme.
 **/
if ( ! function_exists( 'dsk_setup' ) ) {
    function dsk_setup() {
        global $dsk_opt;
        // Load default theme textdomain.
        load_theme_textdomain( 'dsk' , DSK_THEME_DIR . '/languages' );
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        // Add title-tag, it auto title of head
        add_theme_support( 'title-tag' );
        // Enable support for Post Formats.
        add_theme_support( 'post-formats',
            array(
                'video', 'quote', 'link', 'gallery'
            )
        );
        // Register images size
        add_image_size('dsk_blog_tiny_thumb', 70, 50, true);
        add_image_size('dsk_blog_small_thumb', 90, 70, true);
        add_image_size('dsk_blog_large_thumb', 590, 390, true);
        //Setup the WordPress core custom background & custom header feature.
         $default_background = array(
            'default-color' => '#FFF',
        );
        add_theme_support( 'custom-background', $default_background );
        $default_header = array();
        add_theme_support( 'custom-header', $default_header );
        // Register navigations
        register_nav_menus( array(
            'main_navigation' => esc_html__( 'Main navigation', 'dsk' ),
            'categories_navigation'  => esc_html__( 'Categories navigation', 'dsk' ),
            'myaccount_navigation'  => esc_html__( 'My account navigation', 'dsk' ),
        ) );
    }
    add_action ( 'after_setup_theme', 'dsk_setup' );
}

/** 
    Add class for body
 **/
add_filter( 'body_class', 'dsk_bodyclass' );
function dsk_bodyclass( $classes ) {
    $classes[] = 'layout-type-'.dsk_layouttype('layouttype');
    if( dsk_themeoption('advance_tooltip', 1) == 1){
        $classes[] = 'use-tooltip';
    }
    if( dsk_themeoption('use_stickmenu') == 1){
        $classes[] = 'use_stickmenu';
    }
    if ( dsk_themeoption('woo_uselazyload', 0) == 1 ){
        $classes[] = 'use_lazyload';
    }
    if ( is_page() && dsk_metabox('useslideshow') == 1 && dsk_metabox('revolutionslider') != '' ) {
        $classes[] = 'use-slideshow';
    }
    if ( is_page() && dsk_metabox('page_class') != '' ) {
        $classes[] = dsk_metabox('page_class');
    }
    $classes[] = 'header-'.dsk_getoption('header_style', 'style1');
    $classes[] = 'footer-'.dsk_getoption('footer_layout', 'layout_1');
    if ( dsk_getoption('enable_search_cat') == true ) $classes[] = 'enable-search-cat';
    if ( is_front_page()  || is_404() ) {
        $showbreadcrumb = 1;
    }else{
        $showbreadcrumb = dsk_getoption('showbreadcrump', '2');
    }
    if ( is_single() ) { // Single post alway not extra
        $woo_extrawidth = false;
    }else {
        $woo_extrawidth = dsk_getoption('woo_extrawidth');
    }
    if(class_exists('WooCommerce')){
        global $product;
        $classes[] = 'woocommerce';
        if( is_product() && $product->get_type() === 'variable' && dsk_themeoption('woo_designvariations', 1) == 1 && dsk_getoption('use_variation_thumb', 1) == 1 ){
            $classes[] = 'use-variation-thumb';
        }
        if( is_product_category() ){ 
            $showbreadcrumb = dsk_woo_cat_option('showbreadcrump');
        }
        if ( is_product_category() ) {
            $woo_extrawidth = dsk_woo_cat_option('woo_extrawidth'); 
        }elseif( is_product() ) { // Single product
            if( dsk_getoption('woo_gallery_type') == 'n2' ){ 
                $woo_extrawidth = true; 
            }else{
                $woo_extrawidth = false;
            }
        }
    }
    if ( $showbreadcrumb == '1' ) {
         $classes[] = 'no-breadcrumb';
    }
    if ( $woo_extrawidth == false ) {
        $classes[] = 'not-extra-width';
    }
    
    return $classes;
}

function dsk_widgetlocations(){
    // Register widgetized locations
    if(function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => esc_html__( 'Widget Area','dsk' ),
            'id'   => 'sidebar-1', // sidebar-1 for defualt
            'description'   => esc_html__( 'These are widgets for the Widget Area.','dsk' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Product Sidebar','dsk' ),
            'id'   => 'product-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Woo Sidebar','dsk' ),
            'id'   => 'woo-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Woo Sidebar - Sticky','dsk' ),
            'id'   => 'woo-sidebar-sticky',
            'before_widget' => '<div id="%1$s" class="widget woo-sidebar-sticky %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ));
        register_sidebar(array(
            'name' => esc_html__( 'Blog Sidebar','dsk' ),
            'id'   => 'blog-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ));
      
    }
}
add_action( 'widgets_init', 'dsk_widgetlocations' );
/** 
 *  Add styles & scripts
 **/
function dsk_scripts() {
    global $dsk_opt, $wp_query;
    $optimize = '.min'; $optimize = '';
    $css_file = dsk_css_file();
    // Enqueue style
    wp_enqueue_style('bootstrap', DSK_THEME_URI . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owlcarousel', DSK_THEME_URI . '/assets/css/owl.carousel.min.css');
    wp_enqueue_style('slick', DSK_THEME_URI . '/assets/css/slick.min.css');

    wp_dequeue_style('simple-share-buttons-adder-font-awesome');
    wp_dequeue_style('yith-wcwl-font-awesome'); 

    wp_enqueue_style('dsk-ie9', DSK_THEME_URI . '/assets/css/ie9.css');
    wp_enqueue_style('select2', DSK_THEME_URI . '/assets/css/select2.min.css' );
    wp_enqueue_style('woocommerce_prettyPhoto_css');
    wp_enqueue_style('font-awesome', DSK_THEME_URI . '/assets/fonts/awesome/css/font-awesome.min.css'); 
    wp_enqueue_style('flaticon', DSK_THEME_URI . '/assets/fonts/flaticon/flaticon.css');
    wp_enqueue_style('dsk-theme-style', DSK_THEME_URI . '/assets/css/' . $css_file);
    // Register script
    wp_register_script('isotope', DSK_THEME_URI . '/assets/js/isotope.pkgd.min.js', array('jquery'), '', true);
    wp_register_script('dsk-blog-ajax', DSK_THEME_URI . '/assets/js/sns-blog-ajax.js', array('jquery'), '', true);
    wp_register_script('jquery-countdown', DSK_THEME_URI . '/assets/countdown/jquery.countdown.min.js', array('jquery'), '2.1.0', true);
    wp_register_script('threesixty', DSK_THEME_URI . '/assets/js/threesixty.min.js', array('jquery'), '', true);
    // Enqueue script
    wp_enqueue_script('bootstrap', DSK_THEME_URI . '/assets/js/bootstrap.min.js', array('jquery'), '', true);
    wp_enqueue_script('bootstrap-tabdrop', DSK_THEME_URI . '/assets/js/bootstrap-tabdrop.min.js', array('jquery'), '', true);
    wp_enqueue_script('owlcarousel', DSK_THEME_URI . '/assets/js/owl.carousel.min.js', array('jquery'), '', true);
    wp_enqueue_script('slick', DSK_THEME_URI . '/assets/js/slick'.$optimize.'.js', array('jquery'), '', true);
    wp_enqueue_script('select2', DSK_THEME_URI.'/assets/js/select2.min.js', array(), '', true);
    wp_enqueue_script('jquery-waitforimages', DSK_THEME_URI.'/assets/js/jquery.waitforimages'.$optimize.'.js', array(), '', true);
    if(class_exists('WooCommerce')){
        if( dsk_themeoption('woo_uselazyload', 0) == 1 ) {
            wp_enqueue_script('jquery-lazyload', DSK_THEME_URI . '/assets/js/jquery.lazyload'.$optimize.'.js', array('jquery'), '', true);
        }
        wp_enqueue_script('resizesensor', DSK_THEME_URI . '/assets/js/resizesensor.js', array('jquery'), '', true);
        wp_enqueue_script('sticky-sidebar', DSK_THEME_URI . '/assets/js/sticky-sidebar.js', array('jquery'), '', true);
        if( dsk_themeoption('woo_usecloudzoom', 1) == 1 ) {
            wp_enqueue_script('jquery-elevatezoom', DSK_THEME_URI.'/assets/js/jquery.elevatezoom'.$optimize.'.js', array('jquery'), '', true);
        }
        wp_enqueue_script('dsk-woo', DSK_THEME_URI.'/assets/js/sns-woo.js', array('jquery'), '', true);
    }
    wp_enqueue_script('dsk-script', DSK_THEME_URI . '/assets/js/sns-script.js', array('jquery'), '', true);
    // IE 9
    wp_enqueue_script('html5', DSK_THEME_URI . '/assets/js/html5.js', array(), '');
    wp_script_add_data('html5', 'conditional', 'lt IE 9');
    wp_enqueue_script('respond', DSK_THEME_URI . '/assets/js/respond.min.js', array(), '');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');
    // Inline style after dsk-theme-style, The conten render by function dsk_cssinline()
    wp_add_inline_style( 'dsk-theme-style', dsk_cssinline() );
    // Inline scritp after dsk-script. The conten render by function dsk_jsinline()
    wp_add_inline_script( 'dsk-script', dsk_jsinline() );
    // Code to declare the URL to the file handing the AJAX request
    $js_params = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'query_vars' => $wp_query->query_vars
    );
    wp_localize_script('ajax-request', 'sns', $js_params);
}
add_action( 'wp_enqueue_scripts', 'dsk_scripts' );
/**
 * Inline style, with style depend config in Theme Option
**/
function dsk_cssinline(){
    global $dsk_opt;
    $bodycss = ''; $headlinecss = ''; $breadcrumpcss = '';
    if(isset($dsk_opt['body_font']) && is_array($dsk_opt['body_font'])) {
        $body_font = '';
        foreach($dsk_opt['body_font'] as $propety => $value)
            if($value != 'true' && $value != 'false' && $value != '' && $propety != 'subsets' && $propety != 'google' )
                $body_font .= $propety . ':' . $value . ';';
        if($body_font != '') $bodycss .= $body_font;
    }
    if(isset($dsk_opt['headline_font']) && is_array($dsk_opt['headline_font'])) {
        $headline_font = '';
        foreach($dsk_opt['headline_font'] as $propety => $value)
            if($value != 'true' && $value != 'false' && $value != '' && $propety != 'subsets' && $propety != 'google' )
                $headline_font .= $propety . ':' . $value . ';';
        if ($headline_font != '' && isset($dsk_opt['hfont_target']) and $dsk_opt['hfont_target']!='' )  $headlinecss .= $dsk_opt['hfont_target'].'{'.$headline_font.'}';
    }
    if( class_exists('WooCommerce') && is_woocommerce() && is_product_category() ){ 
        $showbreadcrump = dsk_woo_cat_option('showbreadcrump');
        $breadcrumbbg = dsk_woo_cat_option('breadcrumbbg', '', 'image');
    }else {
        $showbreadcrump = dsk_getoption('showbreadcrump', '2');
        $breadcrumbbg = dsk_getoption('breadcrumbbg', '', 'image');
    }
    if ( $showbreadcrump == '2' && !is_array($breadcrumbbg) && $breadcrumbbg != '' ) {
        $breadcrumpcss = '#sns_breadcrumbs.wrap .inner{ background-image:url('.$breadcrumbbg.');}';
    }
    return 'body {'.$bodycss.'}'.$headlinecss.$breadcrumpcss;
}
/* 
 * Inline script, with js variables depend config in Theme Option & Product Option
 */
function dsk_jsinline() {
    $output = '';
    ob_start();
    if(class_exists('WooCommerce')){ ?>
        /* Declaring sns_sp_var variable with config about Product in Theme Option */
        var sns_sp_var = [];
        sns_sp_var['poup'] = '<?php echo (dsk_themeoption('woo_usepopupimage', 1)) ? 1 : 0 ; ?>';
        sns_sp_var['zoom'] = '<?php echo (dsk_themeoption('woo_usecloudzoom', 1)) ? 1 : 0 ; ?>';
        sns_sp_var['zoomtype'] = '<?php echo dsk_getoption('woo_zoomtype', 'lens'); ?>';
        sns_sp_var['zoommobile'] = '<?php echo (dsk_themeoption('woo_usezoommobile', 0)) ? 1 : 0 ; ?>';
        sns_sp_var['thumbnum'] = '<?php echo dsk_themeoption('woo_thumb_num', 5) ; ?>';
        sns_sp_var['lenssize'] = '<?php echo dsk_themeoption('woo_lenssize', 200) ; ?>';
        sns_sp_var['lensshape'] = '<?php echo dsk_themeoption('woo_lensshape', 'round') ; ?>';
        <?php
        global $product;
        $theID = get_the_id();
        $product = wc_get_product( $theID );
        if( is_product() && $product->get_type() === 'variable' && dsk_themeoption('woo_designvariations', 1) == 1 ){
            $attributes = $product->get_attributes();
            ?>
            /* Declaring sns_arr_attr variable if Product Type is Variable Product */
            var sns_arr_attr = {};
            <?php
            foreach ( $attributes as $attribute ) :
                if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
                    continue;
                } else {}
                $terms = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'all' ) );
                $type = '';
                $key_val = array();
                $i = 0;
                foreach ($terms as $term) { $i++;
                    $type = dsk_get_term_byid( $term->term_id, 'dsk_product_attribute_type' );
                    $type = ($type == '') ? 'text' : $type;
                    switch ($type) {
                        case 'color':
                            if( dsk_getoption('use_variation_thumb', 1) == 1){
                                $available_variations = $product->get_available_variations();
                                foreach ($available_variations as $available_variation) {
                                    if( isset($available_variation['attributes']["attribute_$term->taxonomy"]) && $term->slug === $available_variation['attributes']["attribute_$term->taxonomy"] ){
                                        $image_src = get_post_thumbnail_id( $available_variation['variation_id'] ); 
                                        $image_src = wp_get_attachment_image_src( $image_src, 'shop_thumbnail');
                                        $image_src = isset($image_src['0']) ? $image_src['0'] : '';
                                        $key_val[$term->slug] = $image_src;
                                    }
                                }
                            }else {
                                $key_val[$term->slug] = dsk_get_term_byid( $term->term_id, 'dsk_product_attribute_color' );
                            }
                            break;
                        default:
                            $key_val[$term->slug] = $term->name;
                            break;
                    }
                } ?>
                var attributeName = '<?php echo esc_attr($attribute['name']) ?>';
                var data_type = '<?php echo esc_attr($type); ?>';
                var key_val = {};
                <?php foreach ($key_val as $key => $value):?>
                    key_val['<?php echo esc_attr($key) ?>'] = '<?php echo esc_attr($value) ?>';
                <?php endforeach;?>
                sns_arr_attr['attribute_' + attributeName] = {'type': data_type, key_val};
            <?php
            endforeach;
        }
    } ?>
    /* Declaring ajaxurl variable */
    if (typeof ajaxurl == 'undefined') {
        var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
    }
    <?php
    $output = '/* <![CDATA[ */ ' . ob_get_clean() . '/* ]]> */';
    return $output;
}
/*
 * Enqueue admin styles and scripts
 */
function dsk_admin_styles_scripts(){
    wp_enqueue_style('dsk-admin-style', DSK_THEME_URI.'/assets/css/admin-style.css');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script('dsk-admin-template-js', DSK_THEME_URI.'/assets/js/sns-admin-template.js', array( 'jquery', 'wp-color-picker' ), false, true);
}
add_action('admin_enqueue_scripts', 'dsk_admin_styles_scripts');
/**
 * Editor style
 **/
add_editor_style('assets/css/editor-style.css');
/* 
 * Add tpl footer
 */
function dsk_tplfooter() {
    ob_start();
    require DSK_THEME_DIR . '/tpl-footer.php';
    echo ob_get_clean();
}
add_action('wp_footer', 'dsk_tplfooter');
/** 
 *  Quick view for product list style
 **/
function dsk_quickview_liststyle(){
    if ( !class_exists('YITH_WCQV_Frontend') ) return;
    global $product;
    $product_id = 0;
    // get product id
    ! $product_id && $product_id = yit_get_prop( $product, 'id', true );
    $button = '<a href="#" class="button yith-wcqv-button" data-product_id="' . esc_attr($product_id) . '">'.esc_html__('Quick view', 'dsk').'</a>';
    echo apply_filters( 'yith_add_quick_view_button_html', $button, esc_html__('Quick view', 'dsk'), $product );
}
/** 
 *  Tile for page, post
 **/
function dsk_pagetitle($dependb = false){
    if ( $dependb == true) {
        if( class_exists('WooCommerce') && is_woocommerce() && is_product_category() ){ 
            $showbreadcrumb = dsk_woo_cat_option('showbreadcrump');
        }else {
            $showbreadcrumb = dsk_getoption('showbreadcrump', '2');
        }
        if ( $showbreadcrumb == '2' ) { return; }
    }
    // Disable title in page
    if( is_page() && function_exists('rwmb_meta') && rwmb_meta('dsk_showtitle') == '2' ) return;
    // Show title in page, single post
    if ( is_single() ) : ?>
        <h3 class="page-header">
            <span><?php echo esc_html__('Blog', 'dsk'); ?></span>
        </h3>
    <?php
    elseif( is_page() || ( is_home() && get_option( 'show_on_front' ) == 'page' ) ) : ?>
        <h1 class="page-header">
            <span><?php the_title(); ?></span>
        </h1>
    <?php 
    // Show title for category page
    elseif ( is_category() ) : ?>
        <h1 class="page-header">
            <span><?php single_cat_title(); ?></span>
        </h1>
    <?php
    // Author
    elseif ( is_author() ) : ?>
        <h1 class="page-header">
            <span>
        <?php
            printf( esc_html__( 'All posts by: %s', 'dsk' ), get_the_author() );
        ?>
            </span>
        </h1>
        <?php if ( get_the_author_meta( 'description' ) ) : ?>
        <header class="archive-header">
            <div class="author-description"><p><?php the_author_meta( 'description' ); ?></p></div>
        </header>
        <?php endif; ?>
    <?php 
    // Tag
    elseif ( is_tag() ) : ?>
        <h1 class="page-header">
            <span>
            <?php printf( esc_html__( 'Tag Archives: %s', 'dsk' ), single_tag_title( '', false ) ); ?>
            </span>
        </h1>
        <?php
        $term_description = term_description();
        if ( ! empty( $term_description ) ) : ?>
        <header class="archive-header">
            <?php printf( '<div class="taxonomy-description">%s</div>', $term_description ); ?>
        </header>
        <?php endif; ?>
    <?php 
    // Search
    elseif ( is_search() ) : ?>
        <h1 class="page-header"><span><?php printf( esc_html__( 'Search Results for: %s', 'dsk' ), get_search_query() ); ?></span></h1>
    <?php
    // Archive
    elseif ( is_archive() ) : ?>
        <h1 class="page-header">
            <?php 
            if ( class_exists('WooCommerce') && is_woocommerce() ) {
                woocommerce_page_title(); 
            }else{
                the_archive_title();
            }
            ?>
        </h1>
        <?php
        if( get_the_archive_description() ): ?>
        <header class="archive-header">
            <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
        </header>
        <?php    
        endif;
        ?>
    <?php
    // Default
    else : ?>
        <h1 class="page-header">
            <span><?php the_title(); ?></span>
        </h1>
    <?php
    endif;
}

// Excerpt Function
if(!function_exists('dsk_excerpt')){
    function dsk_excerpt($limit, $afterlimit='[...]') {
        $limit = ($limit) ? $limit : 55 ;
        $excerpt = get_the_excerpt();
        if( $excerpt != '' ){
           $excerpt = explode(' ', strip_tags( $excerpt ), intval($limit));
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), intval($limit));
        }
        if ( count($excerpt) >= $limit ) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

// Word Limiter
function dsk_limitwords($string, $word_limit) {
    $words = explode(' ', $string);
    if ( $word_limit < count($words) ){
        return implode(' ', array_slice($words, 0, $word_limit)) . ' ...';
    }else{
        return implode(' ', array_slice($words, 0, $word_limit));
    }
}
function dsk_limitcharacter($string, $character_limit) {
    if ( $character_limit < strlen($string) ){
        return substr($string, 0, $character_limit) . ' ...';
    }else{
        return $string;
    }
}
//
if(!function_exists('dsk_sharebox')){
    function dsk_sharebox(){
        if ( class_exists('SimpleShareButtonsAdder\Plugin') ) {
        ?>
        <div class="post-share-block">
            <?php echo do_shortcode('[ssba-buttons]'); ?>
        </div>
        <?php
        }
    }
}
//
if(!function_exists('dsk_relatedpost')){
    function dsk_relatedpost(){
        global $post;
        if($post){
            $post_id = $post->ID;
        }
        
        $relate_count = dsk_themeoption('related_num');
        $get_related_post_by = dsk_themeoption('related_posts_by');

        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => $relate_count,
            'orderby' => 'date',
            'ignore_sticky_posts' => 1,
            'post__not_in' => array ($post_id)
        );
        
        if($get_related_post_by == 'cat'){
            $categories = wp_get_post_categories($post_id);
            $args['category__in'] = $categories;
        }else{
            $posttags = wp_get_post_tags($post_id);
            
            $array_tags = array();
            if($posttags){
                foreach ($posttags as $tag){
                    $tags = $tag->term_id;
                    array_push($array_tags, $tags);
                }
            }
            $args['tag__in'] = $array_tags;
        }
        
        $relates = new WP_Query( $args );
        $template_name = '/framework/tpl/posts/related_post.php';
        if(is_file(DSK_THEME_DIR.$template_name)) {
            include(DSK_THEME_DIR.$template_name);
        }
        wp_reset_postdata();
    }
}

/*
 * Function to display number of posts.
 */
function dsk_get_post_views($post_id){
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if($count == ''){
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return esc_html__('0 view', 'dsk');
    }
    return $count. esc_html__(' View', 'dsk');
}
/*
* Redmore for excerpt
*/
function dsk_excerpt_more( $link ) {
    if ( is_admin() ) {
        return $link;
    }
    $link = sprintf(
        '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
        esc_url( get_permalink( get_the_ID() ) ),
        '<span>'.esc_html__('Read More', 'dsk').'</span><span class="meta-nav">&#8594;</span>'
    );
    return $link;
}
add_filter( 'excerpt_more', 'dsk_excerpt_more' );
/*
 * Function to count views.
 */
function dsk_set_post_views($post_id){
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if($count == ''){
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    }else{
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}


function dsk_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <?php $add_below = ''; ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
        <div class="comment-body">
            <div class="comment-user-meta">
                <?php echo get_avatar($comment, 80); ?>
                <div class="comment-head">
                    <h4 class="comment-user"><?php echo get_comment_author_link(); ?></h4>
                    <div class="date">
                        <?php 
                        printf(esc_html__('%1$s at %2$s', 'dsk'), get_comment_date(),  get_comment_time()) 
                        ?>
                    </div>
                    <div class="comment-meta">
                        <?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'dsk'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
                        <?php edit_comment_link(esc_html__('Edit', 'dsk'),'  ','') ?>
                    </div>
                </div>
                <?php if ($comment->comment_type != 'pingback'): ?>
                <div class="comment-content">
                    <?php if ($comment->comment_approved == '0') : ?>
                    <p>
                        <em><?php echo esc_html__('Your comment is awaiting moderation.', 'dsk') ?></em><br />
                    </p>
                    <?php endif; ?>
                     <?php comment_text() ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
  <?php 
}
/** 
 *  Breadcrumbs
 **/
add_action( 'dsk_before_sns_content', 'dsk_getbigbreadcrumbs', 5 );
function dsk_getbigbreadcrumbs(){
    $showbreadcrump = '';
    if ( ( class_exists('WooCommerce') && is_woocommerce() && is_product() ) ) return; // Dont use for single product
    if( class_exists('WooCommerce') && is_woocommerce() && is_product_category() ){ 
        $showbreadcrump = dsk_woo_cat_option('showbreadcrump');
    }else {
        $showbreadcrump = dsk_getoption('showbreadcrump', '2');
    }
    if ( $showbreadcrump != '2' ) return;
    $bread_class = 'wrap';
    if ( !is_front_page()  && !is_404() ) : ?>
        <div id="sns_breadcrumbs" class="<?php echo esc_attr($bread_class); ?>">
            <div class="container">
                <?php 
                if( is_file( DSK_THEME_DIR . '/tpl-breadcrumb.php' ) ) {
                    echo '<div class="inner">';
                        dsk_pagetitle();
                        include( DSK_THEME_DIR . '/tpl-breadcrumb.php' );
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    <?php endif;
}
add_action( 'dsk_in_sns_content', 'dsk_getsmallbreadcrumbs', 5 );
function dsk_getsmallbreadcrumbs(){
    $showbreadcrump = '';
    if ( is_singular('post') || ( class_exists('WooCommerce') && is_woocommerce() && is_product() && dsk_getoption('woo_gallery_type') != 'n2' )  ) return; // Dont use for single product & single post
    if( class_exists('WooCommerce') && is_woocommerce() && is_product_category() ){ 
        $showbreadcrump = dsk_woo_cat_option('showbreadcrump');
    }elseif( class_exists('WooCommerce') && is_woocommerce() && is_product() && dsk_getoption('woo_gallery_type') == 'n2' ){
        $showbreadcrump = '3';
    }else {
        $showbreadcrump = dsk_getoption('showbreadcrump');
    }
    if ( $showbreadcrump != '3' ) return;
    $bread_class = 'breadcrumb-in-content col-md-12';
    if ( !is_front_page()  && !is_404() ) : ?>
        <div class="<?php echo esc_attr($bread_class); ?>">
            <?php 
            if( is_file( DSK_THEME_DIR . '/tpl-breadcrumb.php' ) ) {
                echo '<div class="inner">';
                    include( DSK_THEME_DIR . '/tpl-breadcrumb.php' );
                echo '</div>';
            }
            ?>
        </div>
    <?php endif;
}

function dsk_getsingleproductbreadcrumbs(){
    if( class_exists('WooCommerce') && is_woocommerce() && is_product() ){ ?>
        <div class="single-product-breadcrumb">
            <?php 
            if( is_file( DSK_THEME_DIR . '/tpl-breadcrumb.php' ) ) {
                echo '<div class="inner">';
                    include( DSK_THEME_DIR . '/tpl-breadcrumb.php' );
                echo '</div>';
            }
            ?>
        </div>
    <?php
    } 
}
/** 
 *  Search Ajax From
 **/
if( !function_exists('dsk_get_searchform') ){
    function dsk_get_searchform($search_box_type = 'def'){
        $exists_woo = (class_exists('WooCommerce'))?true:false;
        if( $exists_woo ){
            $taxonomy = 'product_cat';
            $post_type = 'product';
            $placeholder_text = esc_attr__('Enter keywords here...', 'dsk');
        }else{
            $taxonomy = 'category';
            $post_type = 'post';
            $placeholder_text = esc_attr__('Enter keywords here...', 'dsk');
        }
        $options = '<option value="">'.esc_html__('All categories', 'dsk').'</option>';
        $options .= dsk_get_searchform_option($taxonomy, 0, 0);
        $uq = rand().time();
        echo '<div class="sns-searchwrap" data-useajaxsearch="true" data-usecat-ajaxsearch="true">';
        echo '<div class="sns-ajaxsearchbox">
        <form method="get" id="search_form_' . $uq . '" action="' . esc_url( home_url( '/'  ) ) . '">';
        if( $search_box_type != 'hide_cat' ){
            echo '<select class="select-cat" name="cat">' . $options . '</select>';
        }
        echo '
        <div class="search-input">
            <input type="text" value="' . get_search_query() . '" name="s" id="s_' . $uq . '" placeholder="' . esc_attr($placeholder_text) . '" autocomplete="off" />
            <button type="submit">
                '. esc_html__('Search', 'dsk') .'
            </button>
            <input type="hidden" name="post_type" value="' . esc_attr($post_type) . '" />
            <input type="hidden" name="taxonomy" value="' . esc_attr($taxonomy) . '" />
         </div>
        </form></div>';
        echo '<div class="sbtn-close"></div></div>';
    }
}

if( !function_exists('dsk_get_searchform_option') ){
    function dsk_get_searchform_option($taxonomy = 'product_cat', $parent = 0, $level = 0){
        $options = '';
        $spacing = '';
        for( $i = 0; $i < $level * 3 ; $i++ ){
            $spacing .= '&nbsp;';
        }
        $args = array(
            'number'        => '',
            'hide_empty'   => 1,
            'orderby'      =>'date',
            'order'        =>'desc',
            'parent'       => $parent
        );
        $select = '';
        $categories = get_terms($taxonomy, $args);
        if( is_search() &&  isset($_GET['cat']) && $_GET['cat'] != '' ){
            $select = $_GET['cat'];
        }
        $level++;
        if( is_array($categories) ){
            foreach( $categories as $cat ){
                $options .= '<option value="' . esc_attr($cat->slug) . '"';
                if ($select == $cat->slug) {
                    $options .= ' selected';
                }
                $options .= '>' . esc_html($spacing) . esc_html($cat->name) . '</option>';
                $options .= dsk_get_searchform_option($taxonomy, $cat->term_id, $level);
            }
        }
        return $options;
    }
}

/** 
 *  Search by Title only From
 **/
function dsk_search_by_title_only( $search, $wp_query )  {  
    global $wpdb;  
    if ( empty( $search ) )  
        return $search; // skip processing - no search term in query  
    $q = $wp_query->query_vars;  
    $n = ! empty( $q['exact'] ) ? '' : '%';  
    $search =  
    $searchand = '';  
    foreach ( (array) $q['search_terms'] as $term ) {  
        $term = esc_sql( $wpdb->esc_like( $term ) );  
        $like = $n . $term . $n;
        $search .= $wpdb->prepare( "{$searchand}($wpdb->posts.post_title LIKE %s)", $like );
        $searchand = ' AND ';  
    }  
    if ( ! empty( $search ) ) {  
        $search = " AND ({$search}) ";  
        if ( ! is_user_logged_in() )  
            $search .= " AND ($wpdb->posts.post_password = '') ";  
    } 
    return $search;  
}  
if ( dsk_themeoption('search_title_only') == true ) add_filter( 'posts_search', 'dsk_search_by_title_only', 10, 2 );

/**
 * Ajax search action
 **/
add_action( 'wp_ajax_dsk_ajax_search', 'dsk_ajax_search' );
add_action( 'wp_ajax_nopriv_dsk_ajax_search', 'dsk_ajax_search' );
if( !function_exists('dsk_ajax_search') ){
    function dsk_ajax_search(){
        global $post;
        $exists_woo = (class_exists('WooCommerce'))?true:false;
        if( $exists_woo ){
            $taxonomy = 'product_cat';
            $post_type = 'product';
        }else{
            $taxonomy = 'category';
            $post_type = 'post';
        }
        $num_result = dsk_getoption('search_limit', -1);
        $keywords = $_POST['keywords'];
        $category = isset($_POST['category'])? $_POST['category']: '';
        $args = array(
            'post_type'        => $post_type,
            'post_status'      => 'publish',
            's'                => $keywords,
            'posts_per_page'   => $num_result
        );
        if( $exists_woo && dsk_themeoption('search_title_only') != true ){
            $args['meta_query'] = array(
                array(
                    'key'       => '_visibility',
                    'value'     => array('catalog', 'visible'),
                    'compare'   => 'IN'
                )
            );
        }
        if( $category != '' ){
            $args['tax_query'] = array(
                array(
                    'taxonomy'  => $taxonomy,
                    'terms'     => $category,
                    'field'     => 'slug'
                )
            );
        } 
        $results = new WP_Query($args);
        if( $results->have_posts() ){
            $extra_class = '';
            if( isset($results->post_count, $results->found_posts) && $results->found_posts > $results->post_count ){
                $extra_class = 'allcat-result';
            }
            $html = '<ul class="'.esc_attr($extra_class).'">';
            while( $results->have_posts() ){
                $results->the_post();
                $link = get_permalink($post->ID);
                $image = '';
                if( $post_type == 'product' ){
                    $product = wc_get_product($post->ID);
                    $image = $product->get_image();
                }
                else if( has_post_thumbnail($post->ID) ){
                    $image = get_the_post_thumbnail($post->ID, 'thumbnail');
                }
                $html .= '<li>';
                    if( $image ){
                        $html .= '<div class="thumbnail">';
                            $html .= '<a href="'.esc_url($link).'">'. $image .'</a>';
                        $html .= '</div>';
                    }
                    $html .= '<div class="meta">';
                        $html .= '<a href="'.esc_url($link).'" class="title">'. dsk_ajaxsearch_highlight_key($post->post_title, $keywords) .'</a>';
                        if( $post_type == 'product' ){
                            $html .= '<span class="price">'. $product->get_price_html() .'</span>';
                        }
                    $html .= '</div>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            if( isset($results->post_count, $results->found_posts) && $results->found_posts > $results->post_count ){
                $html .= '<div class="viewall-result">';
                    $html .= '<a href="#">'. sprintf( esc_html__('View all %d results', 'dsk'), $results->found_posts ) .'</a>';
                $html .= '</div>';
            }
            wp_reset_postdata();
            
            $return = array();
            $return['html'] = $html;
            $return['keywords'] = $keywords;
            die( json_encode($return) );
        }else{
            wp_reset_postdata();
            $return = array();
            if( $exists_woo ){
                $return['html'] = esc_html__('No products were found matching your selection', 'dsk');
            }else{
                $return['html'] = esc_html__('No post were found matching your selection', 'dsk');
            }  
            $return['keywords'] = $keywords;
            die( json_encode($return) );
        }
    }
}
/**
 *  Highlight search key
 **/
if( !function_exists('dsk_ajaxsearch_highlight_key') ){
    function dsk_ajaxsearch_highlight_key($string, $keywords){
        $hl_string = '';
        $position_left = stripos($string, $keywords);
        if( $position_left !== false ){
            $position_right = $position_left + strlen($keywords);
            $hl_string_rightsection = substr($string, $position_right);
            $highlight = substr($string, $position_left, strlen($keywords));
            $hl_string_leftsection = stristr($string, $keywords, true);
            $hl_string = $hl_string_leftsection . '<span class="hightlight">' . $highlight . '</span>' . $hl_string_rightsection;
        } else{
            $hl_string = $string;
        }
        return $hl_string;
    }
}

/**
 *  Match with default search
 **/
add_filter('woocommerce_get_catalog_ordering_args', 'dsk_woo_get_catalog_ordering_args');
if( !function_exists('dsk_woo_get_catalog_ordering_args') ){
    function dsk_woo_get_catalog_ordering_args( $args ){
        if( class_exists('WooCommerce') && is_search() && !isset($_GET['orderby']) && get_option( 'woocommerce_default_catalog_orderby' ) == 'menu_order' 
            && 1==1 ){
            $args['orderby'] = '';
            $args['order'] = '';
        }
        return $args;
    }
}
/**
 * Slideshow wrap
 **/
function dsk_slideshow_wrap($container = false){
    if ( is_page() && dsk_metabox('useslideshow') == 1 ): ?>
    <div id="sns_slideshow" class="wrap">
        <?php
        if ( $container == true ) {
            echo '<div class="container">'.do_shortcode('[rev_slider '.esc_attr(dsk_metabox('revolutionslider')).' ]').'</div>'; 
        }else{
            echo do_shortcode('[rev_slider '.esc_attr(dsk_metabox('revolutionslider')).' ]'); 
        }
        ?>
    </div>
    <?php
    endif;
}
/** 
 * Sample data 
 **/
add_action( 'admin_enqueue_scripts', 'dsk_importlib' );
function dsk_importlib(){
    wp_enqueue_script('sampledata', DSK_THEME_URI . '/framework/sample-data/assets/script.js', array('jquery'), '', true);
    wp_enqueue_style('sampledata-css', DSK_THEME_URI . '/framework/sample-data/assets/style.css');
}
add_action( 'wp_ajax_sampledata', 'dsk_importsampledata' );
function dsk_importsampledata(){
    include_once(DSK_THEME_DIR . '/framework/sample-data/sns-importdata.php');
    dsk_importdata();
}
