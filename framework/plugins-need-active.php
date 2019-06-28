<?php
add_action( 'tgmpa_register', 'sns_plugin_activation' );
function sns_plugin_activation() {
    $plugins = array(
            // install Redux Framework, it on wordpress.org/plugins
            array(
                'name'      => esc_html__('Redux Framework', 'dsk'),
                'slug'      => 'redux-framework',
                'required'  => true,
            ),
            array(
                'name'               => esc_html__('Meta Box', 'dsk'),
                'slug'               => 'meta-box',
                'required'           => true,
            ),
            array(
                'name'                  => esc_html__('Slider Revolution', 'dsk'),
                'slug'                  => 'revslider',
                'source'                => 'revslider.zip',
                'required'              => true,
            ),
            array(
                'name'                  => esc_html__('WPBakery Visual Composer', 'dsk'),
                'slug'                  => 'js_composer',
                'source'                => 'js_composer.zip',
                'required'              => true,
            ),
            array(
                'name'                  => esc_html__('DSK Extra', 'dsk'),
                'slug'                  => 'dsk-extra',
                'source'                => 'dsk-extra.zip',
                'required'              => true,
            ),
            array(
                'name'                  => esc_html__('DSK Shortcodes', 'dsk'),
                'slug'                  => 'dsk-shortcodes',
                'source'                => 'dsk-shortcodes.zip',
                'required'              => true,
            ),
            array(
                'name'               => esc_html__('WooCommerce - excelling eCommerce', 'dsk'),
                'slug'               => 'woocommerce',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('YITH WooCommerce Wishlist', 'dsk'),
                'slug'               => 'yith-woocommerce-wishlist',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('YITH WooCommerce Compare', 'dsk'),
                'slug'               => 'yith-woocommerce-compare',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('YITH WooCommerce Quick View', 'dsk'),
                'slug'               => 'yith-woocommerce-quick-view',
                'required'           => true,
            ),
	    	array(
	    		'name'               => esc_html__('YITH WooCommerce Ajax Product Filter', 'dsk'),
	    		'slug'               => 'yith-woocommerce-ajax-navigation',
	    		'required'           => true,
	    	),
            array(
                'name'               => esc_html__('YITH WooCommerce Badge Management', 'dsk'),
                'slug'               => 'yith-woocommerce-badges-management',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('Newsletter', 'dsk'),
                'slug'               => 'newsletter',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('Contact Form 7', 'dsk'),
                'slug'               => 'contact-form-7',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('Simple Share Buttons Adder', 'dsk'),
                'slug'               => 'simple-share-buttons-adder',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('Instagram Feed', 'dsk'),
                'slug'               => 'instagram-feed',
                'required'           => true,
            ),
        );
  
    $config = array(
        'default_path' => esc_url('http://demo.snstheme.com/wp/resource/q2-2019/'),
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Is show notices or not?
        'dismissable'  => false,                   // If false then user cannot colose notices above.
        'is_automatic' => false,                    // If false thene plugin cannot auto active after install.
    );
    tgmpa( $plugins, $config );
}