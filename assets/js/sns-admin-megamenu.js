(function ($) {
	"use strict";
  	var snsmegamenu = {
		timeout : false ,
		$show: '',
		init : function(){
			var iconfield = null ;
			var megaicon = null;
			var iclass = null;
			jQuery('.sns-iconpicker').on('click',function(e){
					iconfield = jQuery('#sns-mega-mitem-icon-'+ jQuery(this).attr('data-pickerid') );
					megaicon = iconfield.parent().find('span.icon-font').find('i');
				    tb_show( jQuery(this).attr('title') , '#TB_inline?width=580&height=450&inlineId=sns_iconmegapicker');
				    jQuery('.mega-icon-option i').each(function(){
				    	if( jQuery(this).attr('class') == megaicon.attr('class') ){
				    		jQuery('.mega-icon-option i').removeClass('selected'); jQuery(this).addClass('selected');
				    	}
				    })
				    return false;
			});
		    jQuery('.mega-icon-option i').live('click', function(e) {
		       e.preventDefault();
		       iclass = jQuery(this).attr('class').replace('selected', '').trim();
			   iconfield.attr('value', iclass);
			   megaicon.attr('class', iclass).attr('style', 'display:inline-block');
			   if( megaicon.attr('class') == '' ) megaicon.attr('style', 'display:none');
			   window.parent.tb_remove();
			});

			// Icon image
			var sns_iconimg_file_frame;
			jQuery( document ).on('click', '.sns-icon-mega-img', function(e){
				e.preventDefault();

				var $__this = jQuery(this);
				var $__this_menu_item_id = jQuery(this).closest('li.menu-item').attr('id');

				// Create the media frame
				sns_iconimg_file_frame = wp.media.frames.downloadable_file = wp.media({
					title: 'Choose an image',
					button: {
						text: 'Use image'
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				sns_iconimg_file_frame.on( 'select', function() {
					var attachment = sns_iconimg_file_frame.state().get( 'selection' ).first().toJSON();
					
					jQuery('#'+$__this_menu_item_id).find('.edit-sns-mega-mitem-icon').val( attachment.url );
					jQuery('#'+$__this_menu_item_id).find( 'img.icon-preview' ).attr( 'src', attachment.url );
					jQuery('#'+$__this_menu_item_id).find('.icon-preview').show();
				});

				// Finally, open the modal.
				sns_iconimg_file_frame.open();
			});

			// Remove Icon image
			jQuery('.sns-remove-icon-mega-img').on('click', function(e){
				e.preventDefault();
				jQuery(this).closest('.field-megamenu-icon').find('span.icon-font').find('i').attr('class', '').hide();
				jQuery(this).closest('.field-megamenu-icon').find('.icon-preview').attr('src', '').hide();
				jQuery(this).closest('.field-megamenu-icon').find('.edit-sns-mega-mitem-icon').attr('value', '');
				return false;
			});

			// Use icon
			jQuery('.field-megamenu-useicon').each(function(){
				var $this = jQuery(this);
				// Checked
				if( $this.find('select.edit-menu-item-menu-useicon option:selected').val() == '' ){
					$this.closest('.sns-megamenu-options').find('.field-megamenu-icon').hide();
				}else{
					if( $this.find('select.edit-menu-item-menu-useicon option:selected').val() == 'font' ){
						$this.closest('.sns-megamenu-options').find('.field-megamenu-icon').css('display', 'block');
						$this.closest('.sns-megamenu-options').find('.sns-iconpicker').css('display', 'inline-block');
						$this.closest('.sns-megamenu-options').find('.sns-icon-mega-img').css('display', 'none');
						$this.closest('.sns-megamenu-options').find('span.icon-font i').css('display', 'inline-block');
					}else if( $this.find('select.edit-menu-item-menu-useicon option:selected').val() == 'image' ){
						$this.closest('.sns-megamenu-options').find('.field-megamenu-icon').css('display', 'block');
						$this.closest('.sns-megamenu-options').find('.sns-iconpicker').css('display', 'none');
						$this.closest('.sns-megamenu-options').find('.sns-icon-mega-img').css('display', 'inline-block');
						$this.closest('.sns-megamenu-options').find('.icon-preview').css('display', 'inline-block');
					}
				}
				$this.find('select.edit-menu-item-menu-useicon').change(function(){
					if( $this.find('select.edit-menu-item-menu-useicon option:selected').val() == '' ){
						$this.closest('.sns-megamenu-options').find('.field-megamenu-icon').hide();
					}else{
						if( $this.find('select.edit-menu-item-menu-useicon option:selected').val() == 'font' ){
							$this.closest('.sns-megamenu-options').find('.field-megamenu-icon').css('display', 'block');
							$this.closest('.sns-megamenu-options').find('.sns-iconpicker').css('display', 'inline-block');
							$this.closest('.sns-megamenu-options').find('.sns-icon-mega-img').css('display', 'none');
							$this.closest('.sns-megamenu-options').find('.icon-preview').attr('src', '').css('display', 'none');
							$this.closest('.sns-megamenu-options').find('input.edit-sns-mega-mitem-icon').attr('value', '');
						}else if( $this.find('select.edit-menu-item-menu-useicon option:selected').val() == 'image' ){
							$this.closest('.sns-megamenu-options').find('.field-megamenu-icon').css('display', 'block');
							$this.closest('.sns-megamenu-options').find('.sns-iconpicker').css('display', 'none');
							$this.closest('.sns-megamenu-options').find('.sns-icon-mega-img').css('display', 'inline-block');
							$this.closest('.sns-megamenu-options').find('span.icon-font i').attr('class', '').css('display', 'none');
							$this.closest('.sns-megamenu-options').find('input.edit-sns-mega-mitem-icon').attr('value', '');
						}
					}
				});
			});

			// megamenu style
			jQuery('.field-megamenu-enable').each(function(){
				var $this = jQuery(this);
				// Checked
				if( $this.find('input.edit-sns-mega-mitem-enable').attr('checked') == 'checked' ){
					$this.closest('.sns-megamenu-options').find('.field-megamenu-usepostwcode').css('display', 'block');
					$this.closest('.sns-megamenu-options').find('.field-megamenu-postwcode').css('display', 'block');
					$this.closest('.sns-megamenu-options').find('.field-megamenu-background').css('display', 'block');
					$this.closest('.sns-megamenu-options').find('.field-megamenu-customcolumnstyle').css('display', 'block');
				}
				
				// on change
				$this.find('input:checkbox').change(function(){
					var $snsMegam_check = (this.checked) ? 'checked' : 'uncheck'; 
					if( $snsMegam_check == 'checked' ){ // display megamenu style
						$this.closest('.sns-megamenu-options').find('.field-megamenu-usepostwcode').show();
						$this.closest('.sns-megamenu-options').find('.field-megamenu-postwcode').show();
						$this.closest('.sns-megamenu-options').find('.field-megamenu-background').show();
						$this.closest('.sns-megamenu-options').find('.field-megamenu-customcolumnstyle').show();
					}else{
						$this.closest('.sns-megamenu-options').find('.field-megamenu-usepostwcode').hide();
						$this.closest('.sns-megamenu-options').find('.field-megamenu-postwcode').hide();
						$this.closest('.sns-megamenu-options').find('.field-megamenu-background').hide();
						$this.closest('.sns-megamenu-options').find('.field-megamenu-customcolumnstyle').hide();
					}
				});
			});
			// Background image
			var sns_bgimg_file_frame;
			jQuery( document ).on('click', '.sns-background-mega-img', function(e){
				e.preventDefault();

				var $__this = jQuery(this);
				var $__this_menu_item_id = jQuery(this).closest('li.menu-item').attr('id');

				// Create the media frame
				sns_bgimg_file_frame = wp.media.frames.downloadable_file = wp.media({
					title: 'Choose an image',
					button: {
						text: 'Use image'
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				sns_bgimg_file_frame.on( 'select', function() {
					var attachment = sns_bgimg_file_frame.state().get( 'selection' ).first().toJSON();
					
					jQuery('#'+$__this_menu_item_id).find('.edit-sns-mega-mitem-background').val( attachment.url );
					jQuery('#'+$__this_menu_item_id).find( 'img.bg-preview' ).attr( 'src', attachment.url );
					jQuery('#'+$__this_menu_item_id).find('.bg-preview').show();
				});

				// Finally, open the modal.
				sns_bgimg_file_frame.open();
			});

			// Remove Background image
			jQuery('.sns-remove-background-mega-img').on('click', function(e){
				e.preventDefault();
				jQuery(this).closest('.field-megamenu-background').find('.bg-preview').hide();
				jQuery(this).closest('.field-megamenu-background').find('.edit-sns-mega-mitem-background').attr('value', '');
				return false;
			});
		},
    }

	snsmegamenu.init();
	jQuery( ".menu-item-bar" ).live( "mouseup", function(event, ui) {
        if ( !jQuery(event.target).is('a') ) {
		     clearTimeout(snsmegamenu.timeout);
	         snsmegamenu.timeout = setTimeout(snsmegamenu.init() , 700);
		}
    });
})(jQuery);