<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post, $product;

$attachment_ids = $product->get_gallery_image_ids();
?>
<div class="thumbnails">
    <?php
    if( dsk_getoption('woo_gallery_type', 'h') == 'h' ){
        echo '<div class="product-thumbs owl-carousel">';
    }else{
        echo '<div class="product-thumbs">';
    }
    if ( has_post_thumbnail() ) {
        $attachment_id = get_post_thumbnail_id();
        $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
        $thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );

        $attributes = array(
            'title'                   => get_post_field( 'post_title', $attachment_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'data-zoom-image'         => $full_size_image[0],
            'data-src'                => $full_size_image[0],
            'data-large_image'        => $full_size_image[0],
            'data-large_image_width'  => $full_size_image[1],
            'data-large_image_height' => $full_size_image[2],
            'class'                   => "woocommerce-main-thumb img-responsive"
        );
        echo '<div data-thumb="'.esc_url( $thumbnail[0] ).'" class="img woocommerce-product-gallery__image">';
        echo wp_get_attachment_image( $attachment_id, 'shop_catalog', false, $attributes );
        echo '</div>';
    } else {
        $thumb_link = wc_placeholder_img_src();
        echo '<div class="img">';
        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', '<img class="woocommerce-main-thumb img-responsive" src="' . esc_url($thumb_link) . '" />', false, $post->ID, '');
        echo '</div>';
    }
    if ( $attachment_ids && has_post_thumbnail() ) {
        foreach ( $attachment_ids as $attachment_id ) {
            $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
            $thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
            $attributes = array(
                'title'                   => get_post_field( 'post_title', $attachment_id ),
                'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
                'data-zoom-image'         => $full_size_image[0],
                'data-src'                => $full_size_image[0],
                'data-large_image'        => $full_size_image[0],
                'data-large_image_width'  => $full_size_image[1],
                'data-large_image_height' => $full_size_image[2],
                'class'                   => "img-responsive"
            );
            echo '<div data-thumb="'.esc_url( $thumbnail[0] ).'" class="img woocommerce-product-gallery__image">';
            echo wp_get_attachment_image( $attachment_id, 'shop_catalog', false, $attributes );
            echo '</div>';
        }
    } 
    echo '</div>';
?>
</div>
