<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
echo '<a href="'.esc_url( add_query_arg( 'add_to_wishlist', $product_id ) ).'" rel="nofollow" data-product-id="'.esc_attr($product_id).'" data-product-type="'.esc_attr($product_type).'" class="'. esc_attr($link_classes).'" >'.esc_html($icon).esc_html($label).'
</a>
<span class="ajax-loading"></span>';