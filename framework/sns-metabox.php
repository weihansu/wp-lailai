<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */
add_filter( 'rwmb_meta_boxes', 'dsk_register_meta_boxes' );
/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
function dsk_register_meta_boxes( $meta_boxes ){
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 'dsk_';
	global $wpdb, $dsk_opt;
	$revsliders =array();
	$revsliders[0] = esc_html__("Don't use", "dsk");
	if ( class_exists('RevSlider') ) {
		$query = $wpdb->prepare("
			SELECT * 
			FROM {$wpdb->prefix}revslider_sliders 
			ORDER BY %s"
			, "ASC");
	    $get_sliders = $wpdb->get_results($query);
	    if($get_sliders) {
		    foreach($get_sliders as $slider) {
			   $revsliders[$slider->alias] = $slider->title;
		   }
	    }
	}
	$default_layout = 'm-r';
	if ( isset($dsk_opt['blog_layout']) ) $default_layout = $dsk_opt['blog_layout'];
	$siderbars = array();
	foreach ($GLOBALS['wp_registered_sidebars'] as $sidebars) {
		$siderbars[ $sidebars['id']] = $sidebars['name'];
	}
	// Layout config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_productcfg',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Product Config', 'dsk' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'product' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
            array(
                'id'       => "{$prefix}breadcrumbbg",
                'type'     => 'image_advanced',
                'name'     => esc_html__("Background image for Breadcrumb", 'dsk'),
                'desc'	   => esc_html__('Just apply when Show Product Title in the Breadcrumb', 'dsk'),
            ),
			array(
				'name'    => esc_html__( 'Gallery Thumbnail Type', 'dsk' ),
				'id'       => "{$prefix}woo_gallery_type",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''  => esc_html__( 'Default', 'dsk' ),
					'h'  => esc_html__( 'Horizontal', 'dsk' ),
					'v'  => esc_html__( 'Vertical', 'dsk' ),
					'n1'      => esc_html__( 'None - Use scrolling layout', 'dsk' ),
                    'n2'      => esc_html__( 'None - Use top slider layout', 'dsk' ),
				)
			),
		 	array(
				'name'    => esc_html__( 'Product Sidebar', 'dsk' ),
				'id'       => "{$prefix}single_product_sidebar",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''  => esc_html__( 'Default', 'dsk' ),
					0  => esc_html__( 'No', 'dsk' ),
					1  => esc_html__( 'Yes', 'dsk' ),
				),
				'desc'		=> esc_html__('Product page with Sidebar. Select "Default" to use in Theme Options.', 'dsk'),
			),
		  	array(
				'name'    => esc_html__( 'Zoom Type for Cloud Zoom', 'dsk' ),
				'id'       => "{$prefix}woo_zoomtype",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''  => esc_html__( 'Default', 'dsk' ),
					'lens'  => esc_html__( 'Lens', 'dsk' ),
					'inner'  => esc_html__( 'Inner', 'dsk' ),
				),
				'desc'		=> '',
			),
			array(
				'id'    => "{$prefix}product_video",
				'name'  => esc_html__( 'Product Video', 'dsk' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				'desc'		  => esc_html__( 'Enter your video url(youtube, video)', 'dsk' ),
				// Input size
				'size'  => 50,
			),
			array(
				'name'    => esc_html__( 'Use Variation Thumbnail for Variable product', 'dsk' ),
				'id'       => "{$prefix}use_variation_thumb",
				'type'     => 'select',
				'std'  => 1,
				'options'  => array(
					1  => esc_html__( 'Yes', 'dsk' ),
					0  => esc_html__( 'No', 'dsk' ),
				),
				'desc'		=> esc_html__('Just applies for Variable Product', 'dsk'),
			),
		)
	);
	// Layout config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_layout',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Layout Config', 'dsk' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			// Layout Type
			array(
				'name'        => esc_html__( 'Layout Type', 'dsk' ),
				'id'          => "{$prefix}layouttype",
				'type'        => 'layouttype',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'm' => esc_html__( 'Without Sidebar', 'dsk' ),
					'l-m' => esc_html__( 'Use Left Sidebar', 'dsk' ),
					'm-r' => esc_html__( 'Use Right Sidebar', 'dsk' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => $default_layout,
				'placeholder' => esc_html__( '--- Select a layout type ---', 'dsk' ),
			),
			// Left Sidebar
			array(
				'name'  => esc_html__( 'Left Sidebar', 'dsk' ),
				'id'    => "{$prefix}leftsidebar",
				'type'  => 'select',
				'options'	=> $siderbars,
				'multiple'	=> false,
				'std'		=> 'left-sidebar',
				'placeholder' => esc_html__( '--- Select a sidebar ---', 'dsk' ),
			),
			// Right Sidebar
			array(
				'name'  => esc_html__( 'Right Sidebar', 'dsk' ),
				'id'    => "{$prefix}rightsidebar",
				'type'  => 'select',
				'options'	=> $siderbars,
				'multiple'	=> false,
				'std'		=> 'right-sidebar',
				'placeholder' => esc_html__( '--- Select a sidebar ---', 'dsk' ),
			),
			
		)
	);
	
	$menus = get_terms('nav_menu', array( 'hide_empty' => false ));
	$menu_options[''] = __('Default Menu...', 'dsk');
	foreach ( $menus as $menu ){
		$menu_options[$menu->term_id] = $menu->name;
	}
	
	// Page config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_pageconfig',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Page Config', 'dsk' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			array(
				'name'    => esc_html__( 'Want use custom logo?', 'dsk' ),
				'id'      => "{$prefix}header_logo",
				'type'    => 'image_advanced',
				'desc'		=> esc_html__('It priority more than Logon in theme option', 'dsk'),
			),
			array(
				'name'    => esc_html__( 'Header Style', 'dsk' ),
				'id'       => "{$prefix}header_style",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''   	  => esc_html__( 'Default', 'dsk' ),
					'style1'  => esc_html__( 'Style1', 'dsk' ),
					'style2'  => esc_html__( 'Style2', 'dsk' ),
				),
				'desc'		=> esc_html__('Select Header style. ', 'dsk'),
			),
			array(
				'name'    => esc_html__( 'Style of menu category', 'dsk' ),
				'id'       => "{$prefix}mcat_style",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''   	  => esc_html__( 'Default', 'dsk' ),
					'1'  => esc_html__( 'Big item', 'dsk' ),
					'2'  => esc_html__( 'Inline icon', 'dsk' ),
				),
			),
			array(
				'name'    => esc_html__( 'Enable Search Category for Live Ajax Search', 'dsk' ),
				'id'       => "{$prefix}enable_search_cat",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''   	  => esc_html__( 'Default', 'dsk' ),
					true  => esc_html__( 'Yes', 'dsk' ),
					false  => esc_html__( 'No', 'dsk' ),
				),
			),
			array(
				'name'    => esc_html__( 'Use Slideshow', 'dsk' ),
				'id'      => "{$prefix}useslideshow",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'dsk' ),
					'2' => esc_html__( 'No', 'dsk' ),
				),
				'std'         => '2',
			),
			array(
				'name'    => esc_html__( 'Select Slideshow', 'dsk' ),
				'id'      => "{$prefix}revolutionslider",
				'type'    => 'select',
				'options' =>  $revsliders ,
				'std'         => '',
			),
			array(
				'name'    => esc_html__( 'Show Title', 'dsk' ),
				'id'      => "{$prefix}showtitle",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'dsk' ),
					'2' => esc_html__( 'No', 'dsk' ),
				),
				'std'         => '1',
			),
			array(
				'name'    => esc_html__( 'Show Breadcrumbs?', 'dsk' ),
				'id'      => "{$prefix}showbreadcrump",
				'type'    => 'select',
				'options' => array(
					'' => esc_html__( 'Default', 'dsk' ),
					'1' => esc_html__( 'No - Dont show', 'dsk' ),
					'2' => esc_html__( 'Show Breadcrumbs before the Content', 'dsk' ),
					'3' => esc_html__( 'Show Breadcrumbs in the Content', 'dsk' ),
				),
				'multiple'	=> false,
				'std'         => '2',
				'desc' => esc_html__( 'Dont apply for Front page.', 'dsk' ),
			),
			array(
				'name'    => esc_html__( 'Want use Background image for Breadcrumbs?', 'dsk' ),
				'id'      => "{$prefix}breadcrumbbg",
				'type'    => 'image_advanced',
			),
			array(
				'name'    => esc_html__( 'Use extra width for Main Content?', 'dsk' ),
				'id'       => "{$prefix}woo_extrawidth",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''   	  => esc_html__( 'Default', 'dsk' ),
					true  => esc_html__( 'Yes', 'dsk' ),
					false  => esc_html__( 'No', 'dsk' ),
				),
			),
			array(
				'name'    => esc_html__( 'Footer Style', 'dsk' ),
				'id'       => "{$prefix}footer_layout",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''  => esc_html__( 'Default', 'dsk' ),
					'1'  => esc_html__( 'Style 1', 'dsk' ),
					'2'  => esc_html__( 'Style 2', 'dsk' ),
					'3'  => esc_html__( 'Style 3', 'dsk' ),
					'blank'  => esc_html__( 'Blank', 'dsk'),
				),
				'desc'		=> esc_html__('Select Footer layout. "Default" to use in Theme Options.', 'dsk'),
			),
			array(
				'name'    => esc_html__( 'Config Theme Color for this page?', 'dsk' ),
				'id'      => "{$prefix}page_themecolor",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'dsk' ),
					'2' => esc_html__( 'No', 'dsk' ),
				),
				'std'         => '2',
			),
			array(
				'name' => esc_html__( 'Sellect Theme Color', 'dsk' ),
				'id'   => "{$prefix}theme_color",
				'type' => 'color',
				'desc' => esc_html__( 'It will priority than Theme Color in Theme Option panel', 'dsk' ),
			),
			array(
				'name'    	=> esc_html__( 'Want to use page class?', 'dsk' ),
				'id'       	=> "{$prefix}page_class",
				'type'     	=> 'text',
				'std'  		=> '',
				'desc'		=> esc_html__('It is a class css to add some special style, and just for this page', 'dsk'),
			),
		)
	);
	// Post format - Gallery
	$meta_boxes[] = array(
	    	'id' => 'sns-post-gallery',
		    'title' =>  esc_html__('Gallery Settings','dsk'),
	    	'description' => '',
    		'pages'      => array( 'post' ), // Post type
	    	'context'    => 'normal',
		    'priority'   => 'high',
	    	'fields' => array(
			     array(
			        'name'		=> 'Gallery Images',
			        'desc'	    => 'Upload Images for post Gallery ( Limit is 15 Images ).',
			        'type'      => 'image_advanced',
			        'id'	    => "{$prefix}post_gallery",
	         		'max_file_uploads' => 15 
	        	)
			)
	);
	// Post format - Video
    $meta_boxes[] = array(
		'id' => 'sns-post-video',
		'title' => esc_html__('Featured Video','dsk'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_video",
				'name'  => esc_html__( 'Video', 'dsk' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				// Input size
				'size'  => 50,
			)
		)
	);
	// Post format - Audio
    $meta_boxes[] = array(
		'id' => 'sns-post-audio',
		'title' => esc_html__('Featured Audio','dsk'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_audio",
				'name'  => esc_html__( 'Audio', 'dsk' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				// Input size
				'size'  => 50,
			)
		)
	);
	// Post format - quote
    $meta_boxes[] = array(
		'id' => 'sns-post-quote',
		'title' => esc_html__('Featured Quote','dsk'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_quotecontent",
				'name'  => esc_html__( 'Quote Content', 'dsk' ),
				'type'  => 'textarea',
				// Allow to clone? Default is false
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_quoteauthor",
				'name'    => esc_html__( 'Quote author', 'dsk' ),
				'type'    => 'text',
				'clone' => false,
			),
		)
	);
	// Post format - Link
    $meta_boxes[] = array(
		'id' => 'sns-post-link',
		'title' => esc_html__('Link Settings','dsk'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_linkurl",
				'name'  => esc_html__( 'Link URL', 'dsk' ),
				'type'  => 'text',
				// Allow to clone? Default is false
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_linktitle",
				'name'    => esc_html__( 'Link Title', 'dsk' ),
				'type'    => 'text',
				'clone' => false,
			),
		)
	);

	return $meta_boxes;
}


if ( class_exists( 'RWMB_Field' ) ) {
	class RWMB_Layouttype_Field extends RWMB_Select_Field {
		static function admin_enqueue_scripts(){
			wp_enqueue_style( 'dsk-imgselect', DSK_THEME_URI . '/framework/meta-box/img-select.css' );
		}
	}
	// Js for metabox fields action
	add_action( 'admin_print_scripts', 'dsk_metabox_adminjs');
    function dsk_metabox_adminjs(){
		wp_enqueue_script('dsk-imgselect', DSK_THEME_URI . '/framework/meta-box/sns-metabox.js', array('jquery'), '', true);
	}
}
