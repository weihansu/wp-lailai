<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="block-productinner grid-view style3 product-inner">
	<div class="item-inner">
<?php
/**
 * woocommerce_before_shop_loop_item hook.
 *
 * @hooked woocommerce_template_loop_product_link_open - 10
 */
do_action( 'woocommerce_before_shop_loop_item' );
?>
		<div class="item-img clearfix">
			<div class="item-img-info">
				<a class="product-image" href="<?php the_permalink(); ?>">
<?php
add_action('dsk_grid3_before_item_title', 'woocommerce_show_product_loop_sale_flash', 5);
add_action('dsk_grid3_before_item_title', 'dsk_single_product_thumbnail', 10);
do_action( 'dsk_grid3_before_item_title' );
?>
				</a>
			</div>
			<div class="item-content">
<?php
add_action('dsk_grid3_after_item_title', 'woocommerce_template_loop_rating', 1 );
add_action('dsk_grid3_after_item_title', 'woocommerce_template_loop_product_title', 5);
add_action('dsk_grid3_after_item_title', 'woocommerce_template_loop_price', 10);
do_action( 'dsk_grid3_after_item_title' );
?>
				<div class="buttons-action"><div class="inner">
				<?php
				add_action('dsk_grid3_after_item_thumbnail', 'dsk_item_addtocart', 5 );
				add_action('dsk_grid3_after_item_thumbnail', 'dsk_item_wishlist2', 6 ); 
				add_action('dsk_grid3_after_item_thumbnail', 'dsk_item_compare', 7 ); 
				add_action('dsk_grid3_after_item_thumbnail', 'dsk_quickview_liststyle', 8);
				do_action( 'dsk_grid3_after_item_thumbnail' );
				?>
				</div></div>
			</div>
		</div>
<?php
/**
 * woocommerce_after_shop_loop_item hook.
 *
 * @hooked woocommerce_template_loop_product_link_close - 5
 * @hooked woocommerce_template_loop_add_to_cart - 10
 */
add_action('dsk_grid3_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
do_action( 'dsk_grid3_after_shop_loop_item' );
?>
	</div>
</div>