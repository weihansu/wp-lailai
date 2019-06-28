<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="block-product-inner grid-view style4 product-inner">
	<div class="item-inner">
<?php
/**
 * woocommerce_before_shop_loop_item hook.
 *
 * @hooked woocommerce_template_loop_product_link_open - 10
 */
do_action( 'woocommerce_before_shop_loop_item' );
?>
		<div class="visible-part clearfix">
			<div class="item-img-info">
				<a class="product-image" href="<?php the_permalink(); ?>">
<?php
/**
 * woocommerce_before_shop_loop_item_title hook.
 *
 * @hooked woocommerce_show_product_loop_sale_flash - 10
 * @hooked dsk_product_thumbnail - 11
 */

//do_action( 'woocommerce_before_shop_loop_item_title' );
add_action('dsk_grid4_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash');
do_action( 'dsk_grid4_before_shop_loop_item_title' );
?>
				</a>
				<div class="after-prd-img"><?php do_action( 'dsk_woo_after_product_image' ); ?></div>
			</div>
			
		</div>
		<div class="hover-part">
			<div class="item-info">
<?php
/**
 * woocommerce_shop_loop_item_title hook.
 *
 * @hooked woocommerce_template_loop_product_title - 10
 */
// do_action( 'woocommerce_shop_loop_item_title' );

/**
 * woocommerce_after_shop_loop_item_title hook.
 *
 * @hooked woocommerce_template_loop_rating - 5
 * @hooked woocommerce_template_loop_price - 10
 */
add_action('dsk_grid4_after_item_title', 'dsk_woo_cat_links', 1);
add_action('dsk_grid4_after_item_title', 'woocommerce_template_loop_product_title', 5);
add_action('dsk_grid4_after_item_title', 'woocommerce_template_loop_price', 10);
//add_action('dsk_grid4_after_item_title', 'woocommerce_template_loop_rating', 15);
do_action( 'dsk_grid4_after_item_title' );
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
do_action( 'woocommerce_after_shop_loop_item' );
?>
				</div></div>
			</div>
		</div>
	</div>
</div>