<?php
require_once DSK_THEME_DIR . '/framework/class-tgm-plugin-activation.php'; // Plugin for installation and activation plugins.
require_once DSK_THEME_DIR . '/framework/class-compilesass.php'; // Compile Sass to Css
require_once DSK_THEME_DIR . '/framework/plugins-need-active.php'; // Active somes plugins.
require_once DSK_THEME_DIR . '/framework/sns-options.php'; // Theme Options.
require_once DSK_THEME_DIR . '/framework/sns-metabox.php'; // Metabox
require_once DSK_THEME_DIR . '/framework/sns-menu.php'; // Mega menu
// Get Theme Options's value
$dsk_opt =  get_option('dsk_themeoptions');
require_once DSK_THEME_DIR . '/framework/sns-functions.php'; // SNS function
if ( class_exists('WooCommerce') ) require_once DSK_THEME_DIR . '/framework/sns-woocomerce.php'; // Woo function