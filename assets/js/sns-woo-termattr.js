(function ($) {
    "use strict";
    jQuery('select[id="dsk_product_attribute_type"]').each(function(){
        var $thisSelected = jQuery(this).val();
        if( $thisSelected == 'color' ){
            jQuery('.term-dsk_product_attribute_color').stop(true, true).fadeIn(100);
            jQuery('.term-dsk_product_attribute_image').stop(true, true).fadeOut(0);
        }else{
            jQuery('.term-dsk_product_attribute_color').stop(true, true).fadeOut(0);
            jQuery('.term-dsk_product_attribute_image').stop(true, true).fadeOut(0);
        }
        jQuery(this).on('change', function(){
            if( this.value == 'color' ){
                jQuery('.term-dsk_product_attribute_color').stop(true, true).fadeIn(100);
                jQuery('.term-dsk_product_attribute_image').stop(true, true).fadeOut(0);
            }else{
                jQuery('.term-dsk_product_attribute_color').stop(true, true).fadeOut(0);
                jQuery('.term-dsk_product_attribute_image').stop(true, true).fadeOut(0);
            }
        });
    });

})(jQuery);
