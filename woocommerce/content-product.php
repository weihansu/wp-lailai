<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$gridstyle = dsk_woo_cat_option('woo_gridstyle');
if ( $gridstyle == '' ) {
	$gridstyle = dsk_getoption('woo_gridstyle');
}
$class = 'item-listing';
$class .= ' grid-style' . $gridstyle;
?>
<div <?php post_class($class); ?>>
<?php 
wc_get_template( 'vc/grid'.$gridstyle.'.php' ); 
?>
<?php if ( !is_product() && !is_cart() ) : ?>
	<div class="block-product-inner list-view product-inner">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="item-img">
			<a class="product-image" href="<?php the_permalink(); ?>">
	<?php
	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	?>
			</a>
			<div class="after-prd-img"><?php do_action( 'dsk_lv_woo_after_product_image' ); ?></div>
		</div>
		<div class="item-info">
			<div class="item-content">
			<?php
			add_action( 'dsk_list_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); 
			add_action( 'dsk_list_after_shop_loop_item_title', 'woocommerce_template_loop_product_title', 4);
			add_action( 'dsk_list_after_shop_loop_item_title', 'woocommerce_template_loop_price', 7 );
			add_action( 'dsk_list_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 8 );

			do_action( 'dsk_list_after_shop_loop_item_title' );
			?>
			</div>
			<div class="action-wrap">
				<div class="buttons-action"><div class="inner">
<?php
/**
 * woocommerce_after_shop_loop_item hook.
 *
 * @hooked woocommerce_template_loop_product_link_close - 5
 * @hooked woocommerce_template_loop_add_to_cart - 10
 */
add_action( 'dsk_list_after_shop_loop_item', 'dsk_item_addtocart', 10);
add_action( 'dsk_list_after_shop_loop_item', 'dsk_item_wishlist', 11);
add_action( 'dsk_list_after_shop_loop_item', 'dsk_item_compare', 12);
add_action( 'dsk_list_after_shop_loop_item', 'dsk_quickview_liststyle', 14);
do_action( 'dsk_list_after_shop_loop_item' );
?>
				</div></div>
			</div>
		</div>
	</div>
<?php endif; ?>
</div>
