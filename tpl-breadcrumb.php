<?php
// Get the query & post information
global $post, $wp_query;
$category = get_the_category();

// Settings
$separator  = '/';
$id         = 'breadcrumbs';
$class      = 'breadcrumbs';

// Build the breadcrums
echo '<div id="' . esc_attr($id) . '" class="' . esc_attr($class) . '">';
    // Home page
    echo '<a class="home" href="' . esc_url( home_url('/') ) . '" title="' . esc_attr__('Home', 'dsk') . '">'.esc_html__('Home', 'dsk').'</a>';
    echo '<span class="navigation-pipe">' . $separator . '</span>';
    
    if ( class_exists('WooCommerce') && is_woocommerce() ) {
        $args = '';
        $args = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
            'delimiter'   => '<span class="navigation-pipe">' . $separator . '</span>',
            'wrap_before' => '',
            'wrap_after'  => '',
            'before'      => '',
            'after'       => '',
            'home'        => ''
        ) ) );

        $breadcrumbs = new WC_Breadcrumb();

        if ( $args['home'] ) {
            $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', esc_url( home_url('/') ) ) );
        }
		
        $args['breadcrumb'] = $breadcrumbs->generate();
		
       wc_get_template( 'global/breadcrumb.php', $args );
        
    }
    elseif ( is_single() && isset($category[0])) {
        // Single post (Only display the first category)
        echo '<a class="bread-cat bread-cat-' . $category[0]->term_id . ' bread-cat-' . $category[0]->category_nicename . '" href="' . esc_url( get_category_link($category[0]->term_id ) ) . '" title="' . esc_attr($category[0]->cat_name) . '">' . esc_html($category[0]->cat_name) . '</a>';
        echo '<span class="navigation-pipe">' . $separator . '</span>';
        echo '<span class="item-current item-' . $post->ID . '">' . get_the_title() . '</span>';
    } else if ( is_category() ) {
        // Category page
        echo '<span class="bread-current bread-cat-' . $category[0]->term_id . ' bread-cat-' . $category[0]->category_nicename . '">' . $category[0]->cat_name . '</span>';
    } else if ( is_page() ) {
        // Standard page
        if( $post->post_parent ){
            // If child page, get parents 
            $anc = get_post_ancestors( $post->ID );
            // Get parents in the right order
            $anc = array_reverse($anc);
            // Parent page loop
            foreach ( $anc as $ancestor ) {
                echo '<a class="bread-parent bread-parent-' . $ancestor . '" href="' . esc_url( get_permalink($ancestor) ) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a>';
                echo '<span class="navigation-pipe">' . $separator . '</span>';
            }
            // Current page
            echo '<span title="' . get_the_title() . '"> ' . get_the_title() . '</span>';
        } else {
            // Just display current page if not parents
            echo '<span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span>'; 
        }
    } else if ( is_tag() ) {
        // Tag page
        // Get tag information
        $term_id = get_query_var('tag_id');
        $taxonomy = 'post_tag';
        $args ='include=' . $term_id;
        $terms = get_terms( $taxonomy, $args );
        // Display the tag name
        echo '<span class="bread-current bread-tag-' . esc_attr($terms[0]->term_id) . ' bread-tag-' . esc_attr($terms[0]->slug) . '">' . esc_html($terms[0]->name) . '</span>';
    } elseif ( is_day() ) {
        // Day archive
        // Year link
        echo '<a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_html(get_the_time('Y')) . esc_html__(' Archives', 'dsk') . '</a>';
        echo '<span class="navigation-pipe">' . $separator . ' </span>';
        // Month link
        echo '<a class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ) . '" title="' . esc_attr(get_the_time('M')) . '">' . esc_html(get_the_time('M')) . esc_html__(' Archives', 'dsk') .'</a>';
        echo '<span class="navigation-pipe">' . $separator . '';
        // Day display
        echo '<span class="bread-current bread-' . esc_attr(get_the_time('j')) . '"> ' . esc_html(get_the_time('jS')) . ' ' . esc_html(get_the_time('M')) . esc_html__(' Archives', 'dsk') . '</span>';
    } else if ( is_month() ) {
        // Month Archive
        // Year link
        echo '<a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'dsk') . '</a>';
        echo '<span class="navigation-pipe">' . $separator . '</span>';
        // Month display
        echo '<span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . esc_html__(' Archives', 'dsk') . '</span>';
    } else if ( is_year() ) {
        // Display year archive
        echo '<span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . esc_html__(' Archives', 'dsk') . '</span>';
    } else if ( is_author() ) {
        // Auhor archive
        // Get the author information
        global $author;
        $userdata = get_userdata( $author );
        // Display author name
        echo '<span class="bread-current bread-current-' . esc_attr($userdata->user_nicename) . '" title="' . esc_attr($userdata->display_name) . '">' . esc_html__('Author: ', 'dsk') . esc_html($userdata->display_name) . '</span>';
    } else if ( get_query_var('paged') ) {
        // Paginated archives
        echo '<span class="bread-current bread-current-' . esc_attr(get_query_var('paged')) . '" title="' . esc_attr__('Page ', 'dsk') . esc_attr(get_query_var('paged')) . '">'.esc_html__('Page', 'dsk') . ' ' . esc_html(get_query_var('paged')) . '</span>';
    } else if ( is_search() ) {
        // Search results page
        echo '<span class="bread-current bread-current-' . esc_attr(get_search_query()) . '" title="' . esc_attr__('Search results for: ', 'dsk') . esc_attr(get_search_query()) . '">' . esc_html__('Search results for: ', 'dsk') . esc_html(get_search_query()) . '</span>';
    } elseif ( is_404() ) {
        // 404 page
        echo '<span>' . esc_html__('Error 404', 'dsk') . '</span>';
    } else{
        if(is_home()){
            echo esc_html__('blog', 'dsk');
        }elseif(class_exists('WooCommerce') && is_shop()){
            echo esc_html__('shop', 'dsk');
        }elseif( class_exists('WooCommerce') && is_woocommerce() ){
            if(is_product()){
                $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
                $single_cat = array_shift( $product_cats );
                if ($single_cat) {
                    echo esc_html($single_cat->name);
                }
            }else{
                echo get_cat_name($wp_query->get_queried_object()->term_id);
            }
        }elseif (is_single() && isset($category[0])){
            echo esc_html($category[0]->cat_name);
        }else if ( is_category() ) {
            echo esc_html($category[0]->cat_name);
        }else if ( is_page() ) {
            echo get_the_title();
            
        }else if ( is_tag() ) {
            // Tag page
            // Get tag information
            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args ='include=' . $term_id;
            $terms = get_terms( $taxonomy, $args );
            echo esc_html($terms[0]->name);
        } else if ( is_author() ) {
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
            echo esc_html($userdata->display_name);
        } else if ( is_attachment() ) {
            echo get_the_title();
        }
    }
echo '</div>';
?>