<?php
if ( ! function_exists( 'dsk_importdata' ) ) {
	function dsk_importdata(){
		$msg = '';
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
		    require_once ABSPATH . '/wp-admin/includes/file.php';
		    WP_Filesystem();
		}
		if ( !class_exists( 'WP_Import' ) ) {
			$class_wp_import = ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) ){
				require_once $class_wp_import;
				var_dump(class_exists( 'WP_Import' ));
			}else{
				$importer_error = true;
			}	  
		}
		if($importer_error){
			die("Import function not ready!");
		}
		
		ob_start();
		$datatype = isset($_POST['datatype']) ? $_POST['datatype'] : '' ;
		if( $datatype=='theme' ){
			$option_json = get_template_directory_uri() . '/framework/sample-data/data/theme-options.json';
	        $option_data = $wp_filesystem->get_contents($option_json);
			dsk_import_themeoptions($option_data);
		}
		if( $datatype=='slider' ){
			if(!dsk_import_revslider()){
				die('<br />You haven\'t install Rev Slider plugin. Slider isn\'t imported<br />');
			}
		}
		if( $datatype=='content' ){
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = false;
			// Delete old menu and import new
			wp_delete_nav_menu('main-categories');
			wp_delete_nav_menu('information');
			wp_delete_nav_menu('my-account');
			wp_delete_nav_menu('main-menu');
			wp_delete_nav_menu('top-menu');
			// Import content
			$wp_import->import(get_template_directory() . '/framework/sample-data/data/all-content.xml');
			// Set menu location
			$locations = get_nav_menu_locations();
			if(empty($locations)){
				$locations = array(
					'main_navigation' => '',
					'categories_navigation' => '',
					'myaccount_navigation' => ''
				);
			}
		    foreach($locations as $locationId => $menuValue){
		        switch($locationId){
		            case 'main_navigation':
		                $menu = get_term_by('name', 'Main Menu', 'nav_menu');
		            break;
		            case 'categories_navigation':
		                $menu = get_term_by('name', 'Main Categories', 'nav_menu');
		            case 'myaccount_navigation':
		                $menu = get_term_by('name', 'My Account', 'nav_menu');
		            break;
		        }
		        if(isset($menu)){
		            $locations[$locationId] = $menu->term_id;
		        }
		    }
		    set_theme_mod('nav_menu_locations', $locations);
		}
		if( $datatype=='widget' ){
			$widgets_json = get_template_directory_uri() . '/framework/sample-data/data/widget_data.json';
	        $widget_data = $wp_filesystem->get_contents($widgets_json);
	        //ob_start();
			if ( !dsk_import_widget($widget_data) ){
				die('Import widget fail');
			}
			//ob_end_clean();
		}
		if( $datatype=='media1' ){
			$wp_import_m = new WP_Import();
			$wp_import_m->fetch_attachments = true;
			// Import media
			$wp_import_m->import(get_template_directory() . '/framework/sample-data/data/media1.xml');
		}
		if( $datatype=='media2' ){
			$wp_import_m = new WP_Import();
			$wp_import_m->fetch_attachments = true;
			// Import media
			$wp_import_m->import(get_template_directory() . '/framework/sample-data/data/media2.xml');
		}
		if( $datatype=='media3' ){
			$wp_import_m = new WP_Import();
			$wp_import_m->fetch_attachments = true;
			// Import media
			$wp_import_m->import(get_template_directory() . '/framework/sample-data/data/media3.xml');
		}

		ob_end_clean();

		if($datatype == 'theme'){
			$msg .= 'Import theme done.';
		}
		elseif($datatype == 'slider'){
			$msg .= 'Import slider done.';
		}
		elseif($datatype == 'content'){
			$msg .= 'Import content done.';
		}
		elseif($datatype == 'widget'){
			$msg .= 'Import widget done.';
		}
		elseif($datatype == 'media1'){
			$msg .= 'Import media1 done.';
		}
		elseif($datatype == 'media2'){
			$msg .= 'Import media2 done.';
		}
		elseif($datatype == 'media3'){
			$msg .= 'Import media3 done. finished!';
		}
		die($msg);
	}
}
if ( ! function_exists( 'dsk_import_themeoptions' ) ){
	function dsk_import_themeoptions($option){
		$option = json_decode($option,true);
		update_option('dsk_themeoptions',$option);
	}
}
if(!function_exists('dsk_import_revslider')){
	function dsk_import_revslider(){
		if(class_exists('UniteBaseAdminClassRev')){
			require_once ABSPATH .'wp-content/plugins/revslider/admin/revslider-admin.class.php';
			if ($handle = @opendir(get_template_directory().'/framework/sample-data/data/revslider')) {
			    while (false !== ($entry = readdir($handle))) {
			        if ($entry != "." && $entry != "..") {
			            $_FILES['import_file']['tmp_name']=get_template_directory().'/framework/sample-data/data/revslider/'.$entry;
			            $slider = new RevSlider();
			            $alias = str_replace('.zip', '', $entry);
			            $aliases = $slider->getAllSliderAliases();
			            if ( !in_array($alias, $aliases) ){
				            ob_start();
							$response = $slider->importSliderFromPost(true, true);
							ob_end_clean();
						}
			        }
			    }
			    closedir($handle);
			}
			return true;
		}
		return false;
	}
}
if(!function_exists('dsk_import_widget')){
	function dsk_import_widget($import_array){
		global $wp_registered_sidebars;
		$json_data 		= $import_array;
    	$json_data 		= json_decode( $json_data, true );
		$sidebars_data 	= $json_data[0];
		$widget_data 	= $json_data[1];
		$new_widgets 	= array( );
		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :
			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
					$title 					= trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index 					= trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data 	= get_option( 'widget_' . $title );
					$new_widget_name 		= dsk_widget_name( $title, $index );
					$new_index 				= trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] 		= $widget_data[$title][$index];
					} else {
						$current_widget_data[$new_index] 		= $widget_data[$title][$index];
						$new_widgets[$title] 					= $current_widget_data;
					}
				endif;
			endforeach;
		endforeach;

		if( isset( $new_widgets ) || isset( $current_sidebars ) ){
			if ( isset( $new_widgets ) ) {
				foreach ( $new_widgets as $title => $content ){
					update_option( 'widget_' . $title, $content );
				}
			}
			if ( isset( $current_sidebars ) ){
				update_option( 'sidebars_widgets', $current_sidebars );
			}
			return true;
		}
		return false;
	}
}
if(!function_exists('dsk_widget_name')){
	function dsk_widget_name($widget_name, $widget_index){
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
}
?>