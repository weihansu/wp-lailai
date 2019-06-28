<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $woocommerce_loop;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
if ( empty( $class ) ) {
	$class = '';
}
if ( empty( $gridstyle ) ) {
	$gridstyle = '';
}
$class .= ' grid-style' . $gridstyle;
$g_arr = array();
if ( isset($thumb) ) {
	$g_arr['thumb'] = $thumb;
}
?>
<div <?php post_class($class); ?>>
	<?php wc_get_template( 'vc/grid'.$gridstyle.'.php', $g_arr); ?>
</div>
