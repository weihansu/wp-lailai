<?php get_header(); ?>
<!-- Content -->
<div id="sns_content" class="sns-woocommerce-page">
	<div class="container">
		<div class="row sns-content">
			<?php do_action('dsk_in_sns_content'); ?>
			<?php dsk_leftcol(); ?>
			<div class="<?php echo dsk_maincolclass(); ?>">
			    <?php
		    	if( is_product() ){
					wc_get_template( 'single-product.php' );
				}else{
					wc_get_template( 'archive-product.php' );
				}
				?>
			</div>
			<?php dsk_rightcol(); ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>