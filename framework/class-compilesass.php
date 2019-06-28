<?php
if ( ! class_exists( 'DSKCompileSass' ) ) {
	class DSKCompileSass {
		function dsk_getstyle($compile = 2, $scss = array('dir' => '', 'name' => ''), $css = array('dir' => '', 'name' => ''), $format = 'scss_formatter_compressed', $variables = array() ) {
			
			if($css['name'] == '') $css['name'] = $scss['name'];
			$scss_variables = '';
			if($variables) {
				foreach($variables as $propety => $value) {
					$scss_variables .= $propety . ':' . $value . ';';
					$css['name'] .= '-'.strtolower(preg_replace('/\W/i', '', $value));
				}
			}
			if( $compile == 2 || !file_exists(get_template_directory() . '/assets/css/' . $css['name'] . '.css') )
				$this->dsk_compilescss($scss, $css, $format, $scss_variables);
			return $css['name'] . '.css';
		}
		function dsk_compilescss($scss, $css, $format, $scss_variables) {
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			if ( class_exists('scssc') && class_exists('scss_compass') ) {
				$sass = new scssc();
				new scss_compass($sass);
				$format = ($format == NULL) ? 'scss_formatter_compressed' : $format;
				$sass->setFormatter($format);
				$sass->addImportPath($scss['dir']);
				$string_sass = $scss_variables . $wp_filesystem->get_contents($scss['dir'] . $scss['name'] . '.scss');
				$string_css = $sass->compile($string_sass);
				$wp_filesystem->put_contents(
					$css['dir'] . $css['name'] . '.css',
					$string_css,
				  	FS_CHMOD_FILE
				);
			}
		}
	}
}
?>