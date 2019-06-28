<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div id="product-<?php the_ID(); ?>" <?php post_class('topslider-layout'); ?>>
	<div class="entry-img gallery_type_<?php echo esc_attr(dsk_getoption('woo_gallery_type', 'h')); ?>">
		<div class="inner">
<?php
/**
* woocommerce_before_single_product_summary hook.
*
* @hooked woocommerce_show_product_sale_flash - 10
* @hooked woocommerce_show_product_images - 20
*/
do_action( 'woocommerce_before_single_product_summary' );
?>
		</div>
	</div>
	<div class="row">
	<div class="container not-extra">
		<div class="second_block clearfix">
			<div class="primary_block row clearfix">
				<div class="summary entry-summary col-sm-6 col-xs-12">
					<div class="summary-inner"><div class="inner">
		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			//add_action('woocommerce_single_product_summary', 'dsk_getsingleproductbreadcrumbs', 1);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt' ,20);
			do_action( 'woocommerce_single_product_summary' );
		?>
					</div></div>
				</div><!-- .summary -->
				<div class="tabs-info col-sm-6 col-xs-12">
					<?php woocommerce_output_product_data_tabs(); ?>
				</div>
			</div>
		</div>
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
		<?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
			// Upsells Product
		    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		    if (dsk_themeoption('woo_upsells') == 1 && dsk_layouttype('layouttype', 'm') == 'm' ) {
		        add_action( 'woocommerce_after_single_product_summary', 'dsk_woo_output_upsells', 15 );
		    }
		    if ( ! function_exists( 'dsk_woo_output_upsells' ) ) {
		        function dsk_woo_output_upsells() {
		            woocommerce_upsell_display( dsk_themeoption('woo_upsells_num', 8), 1 ); // Display n products in rows of 1
		        }
		    }
		    // Related Product
		    if (dsk_themeoption('woo_related') != 1){
		        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		    }else{
		        add_filter( 'woocommerce_output_related_products_args', 'dsk_woo_output_related' );
		          function dsk_woo_output_related( $args ) {
		            $args['posts_per_page'] = dsk_themeoption('woo_related_num', 6); // n related products
		            $args['columns'] = 1; // arranged in 1 columns
		            return $args;
		        }
		    }
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>