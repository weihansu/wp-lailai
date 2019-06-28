(function ($) {
	"use strict";
	$(document).ready(function($){
		if( $('#dsk_layouttype').length > 0 ){
			var selector = document.getElementById('dsk_layouttype');
			var imgLayoutHTML = '';
		    for(var i = 1; i < selector.options.length; i++){
		    	if( selector.options[i].value ){
		    		imgLayoutHTML = imgLayoutHTML + '<span class="img-layout '+selector.options[i].value+'" data-value="'+selector.options[i].value+'" title="'+selector.options[i].text+'"></span>';
		    	}
		    }
		    $('#dsk_layouttype').parent().append(imgLayoutHTML); $('#dsk_layouttype').css('display', 'none');
		}
		$('.img-layout').each(function(){
			// Add active class
			if($(this).attr('data-value') == $('#dsk_layouttype').attr('value')){
				$(this).addClass('active');
			}
			showHideDependLayout($('#dsk_layouttype').attr('value'));
			// Click img select
			$(this).on('click', function() {
				// Change active class
				var $val = $(this).attr('data-value'); $('.img-layout').removeClass('active'); $(this).addClass('active');
				// Set value for select
				$('#post-body #dsk_layouttype').attr('value', $val);
				if( typeof $('#post-body #dsk_layouttype').attr('data-selected') != 'undefined' ){
					$('#post-body #dsk_layouttype').attr('data-selected', $val);
				}
				// Hide or show field codition
				showHideDependLayout($val);
			});
		});
		//
		if ( $('#page_template').attr('value') == 'fullwidth.php' || $('#page_template').attr('value') == 'sidepage.php' ){
			$('#sns_layout').fadeOut(500);
		}else{
			$('#sns_layout').fadeIn(500);
		}
		
		$('#page_template').change(function(){
			if( $(this).attr('value') == 'fullwidth.php' || $('#page_template').attr('value') == 'sidepage.php' ){
				$('#sns_layout').fadeOut(500);
			}else{
				$('#sns_layout').fadeIn(500);
			}
		})
		function showHideDependLayout($val){
			if( $val == 'm' ){
				$('#post-body #dsk_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
				$('#post-body #dsk_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			}else if( $val == 'l-m' ){
				$('#post-body #dsk_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
				$('#post-body #dsk_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			}else if( $val == 'm-r' ){
				$('#post-body #dsk_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
				$('#post-body #dsk_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			}
		}
		// Enable layout config
		$('#post-body input[name="dsk_enablelayoutconfig"]').each(function(){
			if( $(this).attr('checked') == 'checked' ) enableLayoutConfig( $(this).attr('value') );
			$(this).change(function(){
				enableLayoutConfig( $(this).attr('value') );console.log($(this).attr('value'));
			})
		})
		function enableLayoutConfig($val){
			if( $val == '1' ){
				$('#post-body #dsk_layouttype').parents('.rwmb-layouttype-wrapper').stop(true,true).fadeIn(500);
				showHideDependLayout($('#dsk_layouttype').attr('value'));
			}else{
				$('#post-body #dsk_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
				$('#post-body #dsk_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
				$('#post-body #dsk_layouttype').parents('.rwmb-layouttype-wrapper').stop(true,true).fadeOut(500);
			}
		}
		//
		if ( $('#post-formats-select input').lenth > 0 ) {
			showHideDependPostFormat($('#post-format-gallery').attr('checked'), '#sns-post-gallery' );
			showHideDependPostFormat($('#post-format-video').attr('checked'), '#sns-post-video' );
			showHideDependPostFormat($('#post-format-audio').attr('checked'), '#sns-post-audio' );
			showHideDependPostFormat($('#post-format-quote').attr('checked'), '#sns-post-quote' );
			showHideDependPostFormat($('#post-format-link').attr('checked'), '#sns-post-link' );
			$('#post-formats-select input').each(function(){
				$(this).on('click', function() {
					showHideDependPostFormat($('#post-format-gallery').attr('checked'), '#sns-post-gallery' );
					showHideDependPostFormat($('#post-format-video').attr('checked'), '#sns-post-video' );
					showHideDependPostFormat($('#post-format-audio').attr('checked'), '#sns-post-audio' );
					showHideDependPostFormat($('#post-format-quote').attr('checked'), '#sns-post-quote' );
					showHideDependPostFormat($('#post-format-link').attr('checked'), '#sns-post-link' );
				});
			});
		}
		function showHideDependPostFormat($checked, $id){
			if( $checked == 'checked' ){
				$($id).stop(true,true).fadeIn(500);
			}else {
				$($id).stop(true,true).fadeOut(500);
			}
		}
		// Header style
		$('#post-body select[name=dsk_header_style]').each(function(){
			if ( $(this).attr('value') == 'style1' ) {
				$('#post-body select#dsk_mcat_style').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
			}else {
				$('#post-body select#dsk_mcat_style').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			}
			$(this).change(function(){
				if ( $(this).attr('value') == 'style1' ) {
					$('#post-body select#dsk_mcat_style').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
				}else {
					$('#post-body select#dsk_mcat_style').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
				}
			})
		});
		// Breadcumd
		$('#post-body select[name=dsk_showbreadcrump]').each(function(){
			if ( $(this).attr('value') == '2' ) {
				$('#post-body input[name=dsk_breadcrumbbg]').parents('.rwmb-image_advanced-wrapper').stop(true,true).fadeIn(500);
			}else {
				$('#post-body input[name=dsk_breadcrumbbg]').parents('.rwmb-image_advanced-wrapper').stop(true,true).fadeOut(500);
			}
			$(this).change(function(){
				if ( $(this).attr('value') == '2' ) {
					$('#post-body input[name=dsk_breadcrumbbg]').parents('.rwmb-image_advanced-wrapper').stop(true,true).fadeIn(500);
				}else {
					$('#post-body input[name=dsk_breadcrumbbg]').parents('.rwmb-image_advanced-wrapper').stop(true,true).fadeOut(500);
				}
			})
		});
		// Revolution
		$('#post-body input[name=dsk_useslideshow]').each(function(){
			if( $(this).attr('checked') == 'checked' ){
				if ( $(this).attr('value') == '1' ) {
					$('#post-body select#dsk_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
				}else {
					$('#post-body select#dsk_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
				}
			}
			$(this).change(function(){
				if ( $(this).attr('value') == '1' ) {
					$('#post-body select#dsk_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
				}else {
					$('#post-body select#dsk_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
				}
			})
		});
		// Theme color
		$('#post-body input[name=dsk_page_themecolor]').each(function(){
			if( $(this).attr('checked') == 'checked' ){
				if ( $(this).attr('value') == '1' ) {
					$('#post-body input#dsk_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeIn(500);
				}else {
					$('#post-body input#dsk_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeOut(500);
				}
			}
			$(this).change(function(){
				if ( $(this).attr('value') == '1' ) {
					$('#post-body input#dsk_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeIn(500);
				}else {
					$('#post-body input#dsk_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeOut(500);
				}
			})
		});
		$(window).load(function(){
			if ( $('#post-format-selector-0').length > 0 ){
				$('#sns-post-gallery, #sns-post-video, #sns-post-audio, #sns-post-quote, #sns-post-link').each(function(){
					$(this).fadeOut(500);
				});
				var $p_vale = $('#post-format-selector-0').attr('value');
				if( $p_vale !== '' && $p_vale !== 'standard' ) {
					$('#sns-post-' + $p_vale).fadeIn(500);
				}
				$('#post-format-selector-0').change(function(){
					$('#sns-post-gallery, #sns-post-video, #sns-post-audio, #sns-post-quote, #sns-post-link').each(function(){
						$(this).fadeOut(500);
					});
					var $p_vale = $('#post-format-selector-0').attr('value');
					if( $p_vale !== '' && $p_vale !== 'standard' ) {
						$('#sns-post-' + $p_vale).fadeIn(500);
					}
				});
			}
		});
	});
})(jQuery);