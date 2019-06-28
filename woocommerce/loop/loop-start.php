<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$class = 'grid';
$id = 'sns_woo_list';
if ( is_shop() || is_product_category() || is_product_tag() ):
	$viewmode = dsk_themeoption('woo_list_modeview');
	if (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'grid') {
		$class = $class;
	}elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list') {
	    $class = 'list';
	}
	else{
	    if ( $viewmode == 'grid' ){
	    	$class = $class;
	    }elseif($viewmode == 'list'){
	    	$class = 'list';
	    }
	}
else:
	$id .= rand();
endif;
$class .= ' row';
$gridcol = dsk_woo_cat_option('woo_grid_col', 3);
?>
<div class="prdlist-content grid-style<?php echo esc_attr(dsk_getoption('woo_gridstyle')); ?>">
	<div id="<?php echo esc_attr($id); ?>" class="products product_list <?php echo esc_attr($class); ?>" data-grid="<?php echo esc_attr($gridcol); ?>">