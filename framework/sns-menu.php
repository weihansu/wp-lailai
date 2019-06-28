<?php
class dsk_MegaMenu {
    function __construct() {
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'dsk_megamenuset' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'dsk_megamenusave'), 10, 3 );
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'dsk_megamenuedit'), 10, 2 );
    }
    function dsk_megamenu_asset(){
    	add_action( 'admin_print_footer_scripts', array( $this, 'dsk_iconmegapicker' ), 99 );
		add_action( 'admin_print_styles', array( $this , 'dsk_loadadmincss'));
		add_action( 'admin_print_scripts', array( $this , 'dsk_loadadminjs'));
    }
    // Set value
	function dsk_megamenuset ( $item ) {
		$this->dsk_megamenu_asset();
		// For 1st level
		$item->enablemega 	= get_post_meta( $item->ID, '_sns_megamenu_item_enable', true );
		$item->stylemega 	= get_post_meta( $item->ID, '_sns_megamenu_item_style', true );
		$item->usepostwcode = get_post_meta( $item->ID, '_sns_megamenu_item_usepostwcode', true );
		$item->postwcode = get_post_meta( $item->ID, '_sns_megamenu_item_postwcode', true );
		// For sub content dropdown
		$item->bgmega = get_post_meta( $item->ID, '_sns_megamenu_item_background', true );
		$item->customcolumnstyle = get_post_meta( $item->ID, '_sns_megamenu_item_customcolumnstyle', true );
		// For 2nd level
		$item->hidetitlemega = get_post_meta( $item->ID, '_sns_megamenu_item_hidetitle', true );
		// All level
		$item->useicon = get_post_meta( $item->ID, '_sns_megamenu_item_useicon', true );
		$item->iconmega = get_post_meta( $item->ID, '_sns_megamenu_item_icon', true );

		return $item;
	}
	
	// Save option to db	
    function dsk_megamenusave( $menu_id, $menu_item_db_id, $args ) {
		// Enable
		if ( isset( $_REQUEST['sns-mega-mitem-enable'][$menu_item_db_id]) ) {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_enable', 1 );
		    
		    // Megamenu style
		    if ( isset( $_REQUEST['sns-mega-mitem-style'][$menu_item_db_id] ) ){
		    	$style_value = $_REQUEST['sns-mega-mitem-style'][$menu_item_db_id];
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_style', $style_value);
		    }
		    // Megamenu usepostwcode
		    if ( isset( $_REQUEST['sns-mega-mitem-usepostwcode'][$menu_item_db_id] ) ){
		    	$usepostwcode = $_REQUEST['sns-mega-mitem-usepostwcode'][$menu_item_db_id];
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_usepostwcode', $usepostwcode);
		    }
		    // Megamenu postwcode
		    if ( isset( $_REQUEST['sns-mega-mitem-postwcode'][$menu_item_db_id] ) ){
		    	$postwcode = $_REQUEST['sns-mega-mitem-postwcode'][$menu_item_db_id];
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_postwcode', $postwcode);
		    }
		    // Background image
			if ( isset( $_REQUEST['sns-mega-mitem-background'][$menu_item_db_id]) ) {
			    $bg_value = $_REQUEST['sns-mega-mitem-background'][$menu_item_db_id];
			    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_background', $bg_value );
			}
			// customcolumns
			if ( isset( $_REQUEST['sns-mega-mitem-customcolumnstyle'][$menu_item_db_id]) ) {
			    $customcolumns_value = $_REQUEST['sns-mega-mitem-customcolumnstyle'][$menu_item_db_id];
			    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_customcolumnstyle', $customcolumns_value );
			}
			
		} else {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_enable', 0 );
		    
		    // Megamenu style
		    if ( isset( $_REQUEST['sns-mega-mitem-style'][$menu_item_db_id] ) ){
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_style', '');
		    }
		    // Megamenu usepostwcode
		    if ( isset( $_REQUEST['sns-mega-mitem-usepostwcode'][$menu_item_db_id] ) ){
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_usepostwcode', '');
		    }
		    // Megamenu postwcode
		    if ( isset( $_REQUEST['sns-mega-mitem-postwcode'][$menu_item_db_id] ) ){
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_postwcode', '');
		    }
		    // Background image
			if ( isset( $_REQUEST['sns-mega-mitem-background'][$menu_item_db_id]) ) {
			    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_background', '' );
			}
			// customcolumns
			if ( isset( $_REQUEST['sns-mega-mitem-customcolumnstyle'][$menu_item_db_id]) ) {
			    $customcolumns_value = $_REQUEST['sns-mega-mitem-customcolumnstyle'][$menu_item_db_id];
			    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_customcolumnstyle', '' );
			}
		}
		
		// Hide title
		if ( isset( $_REQUEST['sns-mega-mitem-hidetitle'][$menu_item_db_id]) ) {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_hidetitle', 1 );
		} else {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_hidetitle', 0 );
		}
		// Use Icon
		if ( isset( $_REQUEST['sns-mega-mitem-useicon'][$menu_item_db_id]) ) {
		    $useicon_value = $_REQUEST['sns-mega-mitem-useicon'][$menu_item_db_id];
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_useicon', $useicon_value );
		}
		// Icon
		if ( isset( $_REQUEST['sns-mega-mitem-icon'][$menu_item_db_id]) ) {
		    $icon_value = $_REQUEST['sns-mega-mitem-icon'][$menu_item_db_id];
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_icon', $icon_value );
		}
		    
    }
	// Edit form
    function dsk_megamenuedit($walker, $menu_id) {
	    return 'dsk_Megamenu_Admin'; 
	}
	// Load css file
	function dsk_loadadmincss(){
		wp_enqueue_style('thickbox');
		wp_enqueue_style('dsk-admin-megamenu', DSK_THEME_URI.'/assets/css/admin_megamenu.css', false, '1.0', 'all' );
		wp_enqueue_style('font-awesome', DSK_THEME_URI . '/assets/fonts/awesome/css/font-awesome.min.css');
		wp_enqueue_style('flaticon', DSK_THEME_URI . '/assets/fonts/flaticon/flaticon.css');
	}
	// Load js file
	function dsk_loadadminjs(){
		wp_enqueue_script('thickbox');
		wp_enqueue_script('dsk-admin-megamenu', DSK_THEME_URI . '/assets/js/sns-admin-megamenu.js', array('jquery'), '', true);
	}
	function dsk_iconmegapicker(){
		global $wp_filesystem;
        // Initialize the Wordpress filesystem, no more using file_put_contents function
        if ( empty( $wp_filesystem ) ) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }
	    $icon_fa = array();
		$content_fa = '';
	    if( file_exists( get_template_directory().'/assets/fonts/awesome/css/font-awesome.css' ) ) {
			$content_fa = $wp_filesystem->get_contents(get_template_directory().'/assets/fonts/awesome/css/font-awesome.css');
	    }
	    preg_match_all('/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/', $content_fa , $matches_fa, PREG_SET_ORDER);
	    foreach($matches_fa as $k => $v){
		   $icon_fa[$k] = $v[1];
	    }
	    $icon_flat = array();
		$content_flat = '';
	    if( file_exists( get_template_directory().'/assets/fonts/flaticon/flaticon.css' ) ) {
			$content_flat = $wp_filesystem->get_contents(get_template_directory().'/assets/fonts/flaticon/flaticon.css');
	    }
	    preg_match_all('/\.(flaticon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/', $content_flat , $matches_flat, PREG_SET_ORDER);
	    foreach($matches_flat as $k => $v){
		   $icon_flat[$k] = $v[1];
	    }

	    ?>
		<div id="sns_iconmegapicker">
		    <div class="mega-icon-option wpb-icon-prefix">
		    <h4 class="icon-heading"><?php echo esc_html__('FontAwesome Icons', 'dsk'); ?></h4>
		    <?php		
		    if( is_array($icon_fa ) && !empty($icon_fa)) {
		        foreach( $icon_fa as $k => $v) { 
		            echo '<i class="fa '.esc_attr($v).'"></i>';
		        }
	     	}?>
	     	<h4 class="icon-heading"><?php echo esc_html__('Flat Icons', 'dsk'); ?></h4>
		    <?php		
		    if( is_array($icon_flat ) && !empty($icon_flat)) {
		        foreach( $icon_flat as $k => $v) { 
		            echo '<i class="'.esc_attr($v).'"></i>';
		        }
	     	}?>
		    </div>
		</div>
		<?php
	}
		
}

// Init dsk_MegaMenu
$sns_mega = new dsk_MegaMenu();
require_once DSK_THEME_DIR . '/framework/mega-menu/admin.php';
require_once DSK_THEME_DIR . '/framework/mega-menu/frontend.php';

?>