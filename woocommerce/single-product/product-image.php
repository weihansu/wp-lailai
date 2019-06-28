<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
?>
<div class="images">
	<?php
	if( dsk_getoption('woo_gallery_type', 'h') == 'h' || dsk_getoption('woo_gallery_type', 'h') == 'n2' ){
        $html = '<div class="product-images owl-carousel">';
    }else{
        $html = '<div class="product-images">';
    }
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		$attributes = array(
			'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
			'data-zoom-image'		  => $full_size_image[0],
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
			'class'                   => "img-responsive woocommerce-main-image"
		);
		$html .= '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="img woocommerce-product-gallery__image">';
		$html .= wp_get_attachment_image( $post_thumbnail_id, 'shop_single', false, $attributes );
		$html .= '</div>';
		if ( has_post_thumbnail() ) {
			$attachment_ids = $product->get_gallery_image_ids();
			if ( $attachment_ids ) {
		        foreach ( $attachment_ids as $attachment_id ) {
		        	$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		            $thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		            $attributes = array(
		                'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
						'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
						'data-zoom-image'		  => $full_size_image[0],
		                'data-src'                => $full_size_image[0],
		                'data-large_image'        => $full_size_image[0],
		                'data-large_image_width'  => $full_size_image[1],
		                'data-large_image_height' => $full_size_image[2],
		                'class'                   => "img-responsive"
		            );
		            $html .= '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="img woocommerce-product-gallery__image">';
		            $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
		            $html .= '</div>';
		        }
		    }
		} else {
			$html .= '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_attr__( 'Awaiting product image', 'dsk' ) );
			$html .= '</div>';
		}
	$html .= '</div>';
	if ( dsk_themeoption('woo_usepopupimage', 1) == 1 )
        $html .= '<span class="popup-image"></span>';
    if ( get_post_meta( $post->ID, 'dsk_product_video', true ) )
    	$html .= '<a class="popup-video" href="'.get_post_meta( $post->ID, 'dsk_product_video', true ).'" title="'.esc_attr__('Product Video', 'dsk').'"></a>';

	echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post->ID );
	?>
</div>
<?php
if ( ( dsk_getoption('woo_gallery_type', 'h') == 'v' || dsk_getoption('woo_gallery_type', 'h') == 'h' ) && dsk_themeoption('woo_usethumb', 1) == 1 ){
	do_action( 'woocommerce_product_thumbnails' );
}


