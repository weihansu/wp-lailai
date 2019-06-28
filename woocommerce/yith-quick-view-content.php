<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

while ( have_posts() ) : the_post(); ?>
 <div class="product">
 	<div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>><div class="gallery_type_<?php echo esc_attr(dsk_getoption('woo_gallery_type', 'h')); ?>">
		<div class="entry-img">
		<?php
		add_action( 'yith_wcqv_product_image', 'woocommerce_show_product_thumbnails', 20 );
		do_action( 'yith_wcqv_product_image' ); 
		?>
		</div>
		<div class="summary entry-summary">
			<div class="summary-inner"><div class="inner">
				<?php do_action( 'yith_wcqv_product_summary' ); ?>
			</div></div>
		</div>
	</div></div>
</div>
<?php endwhile; // end of the loop.