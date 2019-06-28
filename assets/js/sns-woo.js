(function ($) {
	"use strict";
	$(document).ready(function() {
		// Js for OWL
		SnsJsOWL.init();
		// lazyload for woo product
		if( $('body').hasClass('use_lazyload') ){
			$('.product_list').each(function(){
				if( $(this).length > 0 ){
					$(this).find('img.lazy').lazyload();
				}
			});
		}
		// OWL click next/prev show lazyload
	    $('.owl-carousel .owl-nav div').each(function(){
			$(this).on('click', function(){ 
				if( $('body').hasClass('use_lazyload') ){
					var parent_owl = $(this).parents('.owl-carousel');
					var timeout = setTimeout(function() {
				        parent_owl.find("img.lazy:not(.loaded)").trigger("appear");
				    }, 1000);
				}
			});
		});
		// Js for shortcode
		SnsShortcodesJs.init();
		// Js for product view
		SnsJsProductView.init();
		// Js for category view
		SnsToolCategoryView.init();
		
		// Product image, gallery, zoom
		if( $('body.single-product .product.type-product > .gallery_type_h').length ){
			SnsSinglePrdIHG.init('.gallery_type_h');
		}
		if( $('body.single-product .product.type-product > .gallery_type_v').length ){
			SnsSinglePrdIVG.init('.gallery_type_v');
		}
		if( $('body.single-product .product.type-product > .gallery_type_n1').length ){
			SnsSinglePrdN1.init('.gallery_type_n1');
			var tops = 30;
			if ( $('body').hasClass('admin-bar') ) {
				tops = tops + $('body #wpadminbar').height();
			}
			var sidebar_sticky = new StickySidebar('body.single-product .product.type-product > .gallery_type_n1 .entry-summary .summary-inner', {
		        containerSelector: 'body.single-product .product.type-product > .gallery_type_n1',
		        innerWrapperSelector: 'body.single-product .product.type-product > .gallery_type_n1 .entry-summary .summary-inner .inner',
		        topSpacing: tops,
		        bottomSpacing: 30
		    });
		}
		if( $('body.single-product .product.type-product > .gallery_type_n2').length ){
			SnsSinglePrdN2.init('.gallery_type_n2');
		}
		// Variations for Variable Product
		SnsVariationForm.reDesignVariationForm();
		SnsVariationForm.init();
		//
		$('.variations-product-wrap').each(function(){
			if ( !$(this).length ) return;
			var $_img_src = '';
			var $_product_image = $(this).parents('.type-product').find('a.product-image img');
			if ( $_product_image.hasClass('lazy') ) {
				$_img_src = $_product_image.data('original');
			}else{
				$_img_src = $_product_image.attr('src');
			}
			$(this).find('.variable-item a.option').each(function(){
				if ( $_img_src == $(this).attr('data-image-src') ) {
					$(this).addClass('active');
				}
			});
		});
		$('body').on('click', '.product .variations-product-wrap a.option', function(e) {
			e.preventDefault();
			if ( $(this).hasClass('active') ) return false;
			var $img_src = '';
			var $prd = $(this).parents('.type-product');
			var $prd_image = $prd.find('.product-image img');
			if ( $prd_image.hasClass('lazy') ) {
				$img_src = $prd_image.data('original');
			}else{
				$img_src = $prd_image.attr('src');
			}
			$prd.find('.variations-product-wrap a.option').removeClass('active'); 
			$(this).addClass('active');
			var $data_src = $(this).attr('data-image-src');
			if( $data_src != '' ){
				$prd_image.attr('src', $data_src);
				$prd_image.attr('srcset', '');
				$prd_image.attr('sizes', '');
			}
			return false;
		});
		//
		SnsToolCategoryView.wantElevateZoom();
		// Rating
		$('.star-rating .value').each(function(){
			if( typeof $(this).attr('data-width') !== typeof undefined ){
				$(this).css('width', $(this).attr('data-width'));
			}
		})
        // Accordion for category
		$('.product-categories').SnsAccordion({
		});
		// Tooltip
		if ( $('body').hasClass('use-tooltip') ) {
			$('.button.yith-wcqv-button, .compare.btn, .yith-wcwl-add-button .add_to_wishlist').each(function(){
				$(this).attr('data-toggle', 'tooltip').attr('data-original-title', $(this).text().trim());
			});
			// Added Wishlist
			$('.block-product-inner .yith-wcwl-wishlistaddedbrowse a, .block-product-inner .yith-wcwl-wishlistexistsbrowse a').each(function(){
				$(this).attr('data-toggle', 'tooltip').attr('data-original-title', $(this).text().trim());
			});
		}
		
		// Update mini cart number
		if ( $('.sns-cart-number').length && $('.sns-ajaxcart .tongle .number').length ) {
			$('.sns-ajaxcart .tongle .number').html($('.sns-cart-number').html().trim());
		}
		// Ajax complete
		jQuery(document).ajaxComplete(function(e, xhr, settings) {
			if ( settings.dataType == 'script' ) { return; }
			// Click Quick View
			if ( typeof settings.data != 'undefined' && settings.data.match(/yith_load_product_quick_view/i) ) {
				if( $('#yith-quick-view-modal .product.type-product > .gallery_type_h').length ){
					SnsSinglePrdIHG.init('#yith-quick-view-modal .gallery_type_h');
				}
				if( $('#yith-quick-view-modal .product.type-product > .gallery_type_v').length ){
					SnsSinglePrdIVG.init('#yith-quick-view-modal .gallery_type_v');
				}
				if( $('#yith-quick-view-modal .product.type-product > .gallery_type_n1').length ){
					$('#yith-quick-view-modal .gallery_type_n1 .images .product-images').addClass('owl-carousel');
					$('#yith-quick-view-modal .gallery_type_n1 .thumbnails .product-thumbs').addClass('owl-carousel');
					SnsSinglePrdIHG.init('#yith-quick-view-modal .gallery_type_n1');
				}
				if( $('#yith-quick-view-modal .product.type-product > .gallery_type_n2').length ){
					$('#yith-quick-view-modal .gallery_type_n2 .images .product-images').addClass('owl-carousel');
					$('#yith-quick-view-modal .gallery_type_n2 .thumbnails .product-thumbs').addClass('owl-carousel');
					SnsSinglePrdIHG.init('#yith-quick-view-modal .gallery_type_n2');
				}
				SnsVariationForm.init();
			}
			// Update mini wishlist number
			if ( typeof settings.data != 'undefined' && settings.data.match(/add_to_wishlist/i) ) {
				if ( $('.mini-wishlist .tongle .number').length ) {
					var wl_prds = []; wl_prds = JSON.parse(Cookies.get( 'yith_wcwl_products'));
					$('.mini-wishlist .tongle .number').html(wl_prds.length);
				}
			}
			// Update mini cart number
			if ( $('.sns-cart-number').length ) {
				$('.sns-ajaxcart .tongle .number').html($('.sns-cart-number').html().trim());
			}
			// Set loaded for image lazy in .sns-main
			if( $('body').hasClass('use_lazyload') ){
				var timeout = setTimeout(function() {
					$(".sns-main img.lazy:not(.loaded)").lazyload();
				}, 1000);
			}
			if ( $('body').hasClass('use-tooltip') ) {
				// Tolltip for Wishlist & compare
				$('.block-product-inner .yith-wcwl-wishlistaddedbrowse a, .block-product-inner .yith-wcwl-wishlistexistsbrowse a').each(function(){
					$(this).attr('data-toggle', 'tooltip').attr('data-original-title', $(this).text().trim());
				});
				$('.compare.btn.added').each(function(){
					$(this).attr('data-original-title', $(this).text().trim());
				});
				// Tolltip for View cart
				// $('.products .added_to_cart').each(function(){
				// 	if( $(this).text().trim() != '') $(this).attr('data-toggle', 'tooltip').attr('data-original-title', $(this).text().trim());
				// });
			}
			//
			$('.variations-product-wrap').each(function(){
				if ( !$(this).length ) return;
				var $_img_src = '';
				var $_product_image = $(this).parents('.type-product').find('a.product-image img');
				if ( $_product_image.hasClass('lazy') ) {
					$_img_src = $_product_image.data('original');
				}else{
					$_img_src = $_product_image.attr('src');
				}
				$(this).find('.variable-item a.option').each(function(){
					if ( $_img_src == $(this).attr('data-image-src') ) {
						$(this).addClass('active');
					}
				});
				//
				SnsToolCategoryView.wantElevateZoom();
			});
		});
	});
    $(window).load(function(){
		// mode View & Layout grid
		SnsToolCategoryView.modeViewLayoutGrid();
    });
    var SnsJsOWL = {
    	init: function() {
    		// Carousel Cross sell Product(cart page)
			if ( $('.cross-sells .products.product_list').length ) {
				$('.cross-sells .products.product_list').addClass('owl-carousel');
				$('.cross-sells .products.product_list').owlCarousel({
	                loop: ( $('.cross-sells .products.product_list').find('> *').length > 3 ) ? true : false, 
	                autoplay : false, dots: false, nav: true, items : 3,
	                responsive : {
	                    0 : { items: 2},
	                    480 : { items: 3 },
	                    768 : { items: 2 },
	                    992 : { items: 3 },
	                    1200 : { items: 3 },
	                    1800 : { items: 3 }
	                },
	            });
			}
    		// Carousel Related Product
			if ( $('.related.products .product_list').length ) {
				var number_lg = 4;
				if ( !$('body').hasClass('layout-type-m') ){
					number_lg = 3;
				}
				$('.related.products .product_list').addClass('owl-carousel');
				$('.related.products .product_list').owlCarousel({
	                loop: ( $('.related.products .product_list').find('> *').length > number_lg ) ? true : false, 
	                autoplay : false, dots: false, nav: true,items : number_lg,
	                responsive : {
	                    0 : { items: 2},
	                    480 : { items: 3 },
	                    768 : { items: 3 },
	                    992 : { items: number_lg },
	                    1200 : { items: number_lg },
	                    1800 : { items: number_lg }
	                },
	            });
			}
			// Carousel Upsell Product
			if ( $('.sns-main .upsells.products .product_list').length ) {
				var number_lg = 4;
				if ( !$('body').hasClass('layout-type-m') ){
					number_lg = 3;
				}
				$('.sns-main .upsells.products .product_list').addClass('owl-carousel');
				$('.sns-main .upsells.products .product_list').owlCarousel({
	                loop: ( $('.sns-main .upsells.products .product_list').find('> *').length > 4 ) ? true : false, 
	                autoplay : false, dots: false, nav: true, items : 6,
	                responsive : {
	                    0 : { items: 2},
	                    480 : { items: 3 },
	                    768 : { items: 3 },
	                    992 : { items: number_lg },
	                    1200 : { items: number_lg },
	                    1800 : { items: number_lg }
	                },
	            });
			}
			// Shortcode: SNS Products
			$('.sns-products').each(function(){
				if ( $(this).length > 0 && $(this).find('div.product_list').find('> *').length > 0 ){
					var wrapc = $(this).find('div.product_list');
					wrapc.owlCarousel({
						loop: ( $(this).find('div.product_list').find('> *').length > $(this).data('desktop')) ? true : false,
						dots: ( $(this).data('usepaging')=='1' )? true : false,
						nav: ( $(this).data('usenav')=='1' )? true : false,
						//autoHeight: true,
		                items : $(this).data('desktop'),
		                responsive : {
		                    0 : { items: $(this).data('mobilep') },
		                    480 : { items: $(this).data('mobilel') },
		                    768 : { items: $(this).data('tabletp') },
		                    992 : { items: $(this).data('tabletl') },
		                    1200 : { items: $(this).data('tabletl') },
		                    1800 : { items: $(this).data('desktop') }
		                },
					});
				}
			});
			// Shortcode: SNS Flash Sale
			$('.sns-flash-sale').each(function(){
				if ( $(this).length > 0 && $(this).find('div.product_list').find('> *').length > 0 ){
					var wrapc = $(this).find('div.product_list');
					wrapc.owlCarousel({
						loop: ( $(this).find('div.product_list').find('> *').length > $(this).data('desktop')) ? true : false,
						dots: ( $(this).data('usepaging')=='1' )? true : false,
						nav: ( $(this).data('usenav')=='1' )? true : false,
		                items : $(this).data('desktop'),
		                responsive : {
		                    0 : { items: $(this).data('mobilep') },
		                    480 : { items: $(this).data('mobilel') },
		                    768 : { items: $(this).data('tabletp') },
		                    992 : { items: $(this).data('tabletl') },
		                    1200 : { items: $(this).data('tabletl') },
		                    1800 : { items: $(this).data('desktop') }
		                },
					});
				}
			});
			// Shortcode: SNS Special Deal
			$('.sns-special-deal').each(function(){
				if ( $(this).length > 0 && $(this).find('div.owl-carousel').find('> *').length > 0 ){
					var wrapc = $(this).find('div.owl-carousel');
					wrapc.owlCarousel({
						loop: true,
						dots: true,
						nav: false,
						autoplay: true, autoplayHoverPause: true, 
		                items : 1,
					});
				}
			});
    	}
    }
    // Js for product view
    var SnsJsProductView = {
    	init: function() {
			// Tab information
		    if ( $('#sns_tab_informations').length ) {
			    if (window.location.href.indexOf('#comments') > 0 ) {
					$('#sns_tab_informations .nav-tabs').find("li.reviews_tab").addClass("active");
		    		$('#sns_tab_informations .tab-content').find("#tab-reviews").addClass("active in");
				}else{
		    		$('#sns_tab_informations .nav-tabs').find("li").first().addClass("active");
		    		$('#sns_tab_informations .tab-content').find(".tab-pane").first().addClass("active in");
		    	}
		    	$('#sns_tab_informations .nav-tabs').tabdrop();
		    }
		    // Move Compare & Wishlist in form cart
			if ( $('body.single-product .entry-summary form.variations_form').length || $('body.single-product .entry-summary form.cart table.group_table').length ) {
				var wl_c_el = 'body.single-product .entry-summary .yith-wcwl-add-to-wishlist, body.single-product .entry-summary .compare';
				$(wl_c_el).each(function(){
					if ( $(this).length ) {
						$('body.single-product .entry-summary form.cart').append($(this).clone());
						$(this).remove();
					}
				});
			}
    	}
    }
    // Tool for catgory view
    var SnsToolCategoryView = {
    	init: function() {
    		if ( $('.sticky-filter-btn').length ) {
    			$('body').addClass('use-sticky-filter');
	    		$('.sticky-filter-btn, .sticky-product-filter .overlay').on('click', function(e){
					e.preventDefault();
					if($('.sticky-product-filter').hasClass('active')){
						$('.sticky-product-filter .overlay').fadeOut(250);
						$('.sticky-product-filter').removeClass('active');
					} else {
						$('.sticky-product-filter .overlay').fadeIn(250);
						$('.sticky-product-filter').addClass('active');
					}
				});
	    	}
	        // YITH Filter
	        $(document).off('click', '.yith-wcan a').on('click', '.yith-wcan a', function (e) {
	        	e.preventDefault();
	        	$('html, body').stop().animate({
	                scrollTop: $(yith_wcan.scroll_top).offset().top - 20
	            }, 600);
	            $(this).yith_wcan_ajax_filters(e, this);
	        });
	        // Click filter on handle device
		    $('.yith-wcan a').on('click', function (e) {
		        $('.btn-navbar').each(function(){
		        	if( $(this).hasClass('active') ){
		        		$('#sns_content .sns-left, #sns_content .sns-right').removeClass('active');
		        		$(this).find('.overlay').fadeOut(250); $(this).removeClass('active');
		        	}
		        })
		    });
    	},
    	wantElevateZoom: function() {
    		var g_zoomcfg = {
	            responsive: true, zoomType: 'inner', cursor: 'grab', borderSize: 0
	        };
	        $('.type-product .grid-view.style4 .product-image').each( function(){
	        	g_zoomcfg.zoomContainer = $(this);
	        	$(this).find('img').elevateZoom(g_zoomcfg);
	        });
    	},
    	modeViewLayoutGrid: function() {
			$('.mode-view a').on('click', function() {
	            var mode = $(this).data('mode');
	            if( !$(this).hasClass('active') ){
	            	$('.mode-view a').removeClass('active');
		            $(this).addClass('active');
		            if ( $(this).hasClass('list') ) {
			        	$('#sns_woo_list.product_list').removeClass('grid');
			        	$('#sns_woo_list.product_list').addClass('list');
		            }else if( $(this).hasClass('grid') ){
			        	$('#sns_woo_list.product_list').removeClass('list');
			        	$('#sns_woo_list.product_list').addClass('grid');
		            }
		            $.ajax({
		                url: ajaxurl,
		                data:{
		                	action : 'sns_setmodeview',
		                	mode : mode
		                },
		                type: 'POST'
		            });
		            return false;
		        }else{
		        	return false;
		        }
	        });
    	}
    }
    var SnsShortcodesJs = {
    	init: function() {
			$('.sns-360-degree-product').each(function(){ 
				if ( !$(this).length ) return;
				var sns360degree = $(this).find('.content-360').ThreeSixty({
    				totalFrames: $(this).data('total_frame'),
					endFrame: $(this).data('total_frame'),
					currentFrame: 1,
					imgList: '.images',
					progress: '.spinner',
					imagePath: $(this).data('image_path'),
					filePrefix: $(this).data('file_prefix'),
					ext: $(this).data('file_ext'),
					responsive: true,
					height: 512,
					width: 512,
					navigation: $(this).data('navigation'),
					disableSpin: true,
					onReady: function() {
				        setTimeout(function() {
				          sns360degree.play(); sns360degree.$el.find('.nav_bar_play').attr('class', 'nav_bar_stop');
				        }, 2000);
				    }
				});
			});
    	}
    }
	// Begin Class: SnsVariationForm
	var SnsVariationForm = {
        init: function() {
            var self = this;
            //
            if ( $('form.variations_form').length ) {
	            var $product        = $('.variations_form').closest( '.product' );
	            var $product_img    = $product.find( 'div.product-images .woocommerce-main-image' );
	            $product.data('img-osrc', $product_img.attr('src'));
	            $product.data('img-title', $product_img.attr('title'));
	            $product.data('img-src', $product_img.attr('data-src'));
	        }
            $( document ).on( 'reset_image', '.variations_form', function(event) {
                var $product        = $(this).closest( '.product' );
                var $product_images = $product.find('.product-images');
                var $product_thumbs = $product.find('.product-thumbs');
                // Begin: Switch to first Image
                if ($product_images.length) {
                    $product_images.trigger('to.owl.carousel', [0, 300, true]);
                }
                // Swap Image Zoom
                var $product_img    = $product.find( 'div.product-images .woocommerce-main-image' );
                var o_src           = $product_img.attr('data-o_src');
                var o_title         = $product_img.attr('data-o_title');
                var src          = $product_img.attr('data-src');
                if ( o_src && o_title && src ) {
                    $product_img.each(function() {
                    	var elevateZoom = $(this).data('elevateZoom');
                    	if (typeof elevateZoom != 'undefined') {
                        	elevateZoom.swaptheimage($(this).attr( 'src' ), $(this).attr( 'data-src' ));
                        }
                    });
                    // Switch Button Popup to first Image
                	var imgsrc = $product_images.data('imgsrc'), imgtitle = $product_images.data('imgtitle');
                    if (typeof imgsrc != 'undefined' && typeof imgtitle != 'undefined') {
                        imgsrc[0] = src; imgtitle[0] = o_title;
                    }
                    $product_images.data('imgsrc', imgsrc); $product_images.data('imgtitle', imgtitle);
                }
                // Begin: Switch to first Thumb
                if ($product_thumbs.length) {
                    $product_thumbs.trigger('to.owl.carousel', [0, 300, true]);
                    $product_thumbs.find('.owl-item:eq(0)').trigger( "click" );
                }
                // Replace first thumb src
                var $thumb_img      = $product.find( '.woocommerce-main-thumb' );
                var o_thumb_src     = $thumb_img.attr('data-o_src');
                if (o_thumb_src) {
                    $thumb_img.attr( 'src', o_thumb_src ).attr( 'srcset', '' );
                }
            });
            $( document ).on( 'click', '.variations_form .reset_variations', function(event) {
            	var $product 			= $(this).closest( '.product' );
            	var $product_images 	= $product.find('.product-images');
                var $product_img     	= $product.find( 'div.product-images .woocommerce-main-image' );
                $product_img.each(function() {
                	$product_img.attr( 'src', $product.data('img-osrc') )
                				.attr( 'data-o_src', $product.data('img-osrc') )
                				.attr( 'srcset', '' )
                				.attr( 'alt', $product.data('img-title') )
                				.attr( 'data-src', $product.data('img-src') );
                	var elevateZoom = $(this).data('elevateZoom');
                	if (typeof elevateZoom != 'undefined') {
                    	elevateZoom.swaptheimage($(this).attr( 'src' ), $(this).attr( 'data-src' ));
                    }
                });
                var imgsrc = $product_images.data('imgsrc'), imgtitle = $product_images.data('imgtitle');
                imgsrc[0] = $product.data('img-src'); imgtitle[0] = $product.data('img-title');
                $product_images.data('imgsrc', imgsrc); $product_images.data('imgtitle', imgtitle);
            });
            $( document ).on( 'found_variation', '.variations_form', function(event, variation) {
                if (typeof variation == 'undefined') {
                    return;
                }
                var $product 			= $(this).closest( '.product' );
                var $product_images 	= $product.find('.product-images');
                var $product_thumbs 	= $product.find('.product-thumbs');
                // Begin: Switch to first Image
                if ($product_images.length) {
                    $product_images.trigger('to.owl.carousel', [0, 300, true]);
                }
                // Begin: Switch to first Thumb
                if ($product_thumbs.length) {
                    $product_thumbs.trigger('to.owl.carousel', [0, 300, true]);
                    $product_thumbs.find('.owl-item:eq(0)').trigger( "click" );
                }
                var $product_img     		= $product.find( 'div.product-images .woocommerce-main-image' );
                var $thumb_img 				= $product.find( '.woocommerce-main-thumb');
                var variation_image 		= variation.image.full_src;
                var variation_link 			= variation.image.src;
                var variation_title 		= variation.image.caption;
                var variation_thumb 		= ( typeof variation.image.thumb_src != 'undefined' ) ? variation.image.thumb_src : variation.image.src ;
                
                // Replace Image & Thumb Src
                var o_src = $product_img.attr('data-o_src');
                if ( ! o_src ) {
                    o_src = ( ! $product_img.attr('src') ) ? '' : $product_img.attr('src');
                    $product_img.attr('data-o_src', o_src );
                }
                var src = $product_img.attr('data-src');
                if ( ! src ) {
                    src = ( ! $product_img.attr('data-src') ) ? '' : $product_img.attr('data-src');
                    $product_img.attr('data-src', src );
                }
                var o_title = $product_img.attr('data-o_title');
                if ( ! o_title ) {
                    o_title = ( ! $product_img.attr('alt') ) ? '' : $product_img.attr('alt');
                    $product_img.attr('data-o_title', o_title );
                }
                var o_thumb_src = $thumb_img.attr('data-o_src');
                if ( ! o_thumb_src ) {
                    o_thumb_src = ( ! $thumb_img.attr('src') ) ? '' : $thumb_img.attr('src');
                    $thumb_img.attr('data-o_src', o_thumb_src );
                }
                var imgsrc = $product_images.data('imgsrc'), imgtitle = $product_images.data('imgtitle');
                if ( variation_link ) {
                    $product_img.attr( 'src', variation_link ).attr( 'data-o_src', variation_link ).attr( 'srcset', '' ).attr( 'alt', variation_title ).attr( 'data-src', variation_image );
                    $thumb_img.attr( 'src', variation_thumb ).attr( 'srcset', '' );
                    if (typeof imgsrc != 'undefined' && typeof imgtitle != 'undefined') {
                        imgsrc[0] = variation_image; imgtitle[0] = variation_title;
                    }
                } else {
                    $product_img.attr( 'src', o_src ).attr( 'data-o_src', o_src ).attr( 'srcset', '' ).attr( 'alt', o_title ).attr( 'data-src', src );
                    $thumb_img.attr( 'src', o_thumb_src ).attr( 'srcset', '' );
                    if (typeof imgsrc != 'undefined' && typeof imgtitle != 'undefined') {
                        imgsrc[0] = src; imgtitle[0] = o_title;
                    }
                }
                // Switch Button Popup to first Image
                $product_images.data('imgsrc', imgsrc); $product_images.data('imgtitle', imgtitle);
                // Swap Image Zoom
                $product_img.each(function() {
                	var elevateZoom = $(this).data('elevateZoom');
                	if (typeof elevateZoom != 'undefined') {
                    	elevateZoom.swaptheimage($(this).attr( 'src' ), $(this).attr( 'data-src' ));
                    }
                });
            });
        },
        reDesignVariationForm: function( $wrap ) {
        	if ( typeof $wrap == 'undefined') var $wrap = '';
        	if ( $wrap != '' ) {
	    		$wrap = $wrap+' .type-product.product-type-variable';
	    	}else{
	    		$wrap = '.type-product.product-type-variable';
	    	}
			if ( $($wrap).length  && typeof sns_arr_attr !== 'undefined' ) { 
				$($wrap).find('.variations select').each(function(){
					var select = $(this), select_div, var_attr = sns_arr_attr[select.attr('name')];
					if ( typeof var_attr == 'undefined' ) { return false; } 
					select_div = $('<div />', {
				                	'class': 'sellect-wrap'
				            	}).insertAfter(select);
					select.hide();
					select.find( 'option' ).each(function (){
						var option_old = $(this), option;
						if ( option_old.attr('value')!='' ) {
							var inner_opt, class_sellect, val_opt = var_attr.key_val[option_old.attr('value')];
							if (var_attr.type == 'color') {
								if (val_opt.indexOf("http:") == 0 || val_opt.indexOf("https:") == 0) {
									inner_opt = $('<span/>', {
												'style':'background-image:url("' + val_opt + '")'
											});
									class_sellect = ' image';
								}else{
				                    inner_opt = $('<span/>', {
													'style':'background:' + val_opt
												});
									class_sellect = ' color';
								}
			                }else if (var_attr.type == 'text') {
			                    inner_opt = $('<span/>', {
												'html': val_opt
											});
								class_sellect = ' text';
			                }
			                option = $('<div/>', {
				                        'class': 'option'+class_sellect,
				                        'data-toggle':'tooltip',
				                        'data-original-title':option_old.text(),
				                        'data-value': option_old.attr('value')
				                    }).appendTo(select_div);
		                    inner_opt.appendTo(option);
							if ( option_old.val() == select.val() ){
								option.addClass('selected');
							}
		                    option.on('click', function () {
		                    	// Update variation values
		                        if ( $(this).hasClass('selected') ) {
		                            select.val('').change();
		                        } else {
		                            select.val( option_old.val() ).change();
		                        }
		                        SnsVariationForm.setSelectedOpt( $(this) );
		                    });
		                }
					});
				});
				$( document ).on( 'click', '.variations_form .reset_variations', function(event) {
					$('.variations_form .sellect-wrap .option').removeClass('selected');
				});
			}
		},
		setSelectedOpt: function( option ) {
	        option.toggleClass('selected');
	        option.siblings().removeClass('selected');
	    },
    }
    // End Class: SnsVariationForm
    // Begin Class: SnsSinglePrdIHG
	var SnsSinglePrdIHG = {
		init: function( $wrap ) {
			var self = this, flag_switch = false;
			if ( typeof sns_sp_var == 'undefined' ) return false;
	    	if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	    		var zoomcfg = {
		            responsive: true, zoomType: sns_sp_var['zoomtype'], cursor: 'grab'
		        };
		        if ( sns_sp_var['zoomtype'] == 'inner' ) {
		        	zoomcfg.borderSize = 0;
		        }else if ( sns_sp_var['zoomtype'] == 'lens' ) {
		        	zoomcfg.lensSize = sns_sp_var['lenssize']; zoomcfg.lensShape = sns_sp_var['lensshape'];
		        }
	    	}
	    	if ( typeof $wrap == 'undefined') var $wrap = '';
	    	if ( $wrap != '' ) {
	    		$wrap = $wrap+' .product-images';
	    	}else{
	    		$wrap = '.product-images';
	    	}
	        $($wrap).each(function() {
	            var $this = $(this),
	                $product = $this.closest('.product'),
	                $product_thumbs = $product.find('.product-thumbs'),
	                image_active = 0;
	            $this.find('img:first-child').waitForImages(true).done(function() {
		            // Carousel for Thumbs
	                $product_thumbs.owlCarousel({
	                    loop: false, autoplay : false, rewind: true, dots: false, nav: true,
	                    items : sns_sp_var['thumbnum'],
	                    responsive : {
		                    0 : { items: sns_sp_var['thumbnum']-1},
		                    480 : { items: sns_sp_var['thumbnum']-1 },
		                    768 : { items: sns_sp_var['thumbnum']-1 },
		                    992 : { items: sns_sp_var['thumbnum']-1 },
		                    1200 : { items: sns_sp_var['thumbnum'] }
		                },
	                    onInitialized: function() {
	                        self.switchImageThumb(null, $product_thumbs, 0);
	                        if ($product_thumbs.find('.owl-item').length < sns_sp_var['thumbnum']) {
	                        	$product_thumbs.find('.owl-nav').hide();
	                        }	
	                    }
	                }).on('click', '.owl-item', function() {
	                    self.switchImageThumb($this, $product_thumbs, $(this).index());
	                });
	                $product_thumbs.on('click', '.owl-prev', function(e) {
	                    self.switchImageThumb($this, $product_thumbs, $product_thumbs.data('thumbselected') - 1);
	                });
	                $product_thumbs.on('click', '.owl-next', function(e) {
	                    self.switchImageThumb($this, $product_thumbs, $product_thumbs.data('thumbselected') + 1);
	                });
	                // Button click to popup Images
	                if ( sns_sp_var['poup'] == '1' ) {
	                    var imgsrc = [], imgtitle = [], i = 0;
	                    var $popup_btn = $product.find('.popup-image');
	                    var $popup_video_btn = $product.find('.popup-video');
	                    $this.find('img').each(function() {
	                        imgsrc[i] = $(this).attr('data-src'); imgtitle[i] = $(this).attr('alt');
	                        i++;
	                    });
	                    $this.data('imgsrc', imgsrc); $this.data('imgtitle', imgtitle);
	                    if (typeof $.fn.prettyPhoto !== 'undefined') {
		                    $($popup_btn).off('click').on('click', function(e) {
		                        e.preventDefault();
		                        $.prettyPhoto.open($this.data('imgsrc'), [], $this.data('imgtitle'), image_active);
		                    });
		                    $popup_video_btn.prettyPhoto({
								hook: 'data-rel', default_width: 750, default_height: 600, social_tools: false, theme: 'pp_woocommerce', horizontal_padding: 20, opacity: 0.8, deeplinking: false
							});
		                }
	                }
	                // Carousel for Images
	                $this.owlCarousel({
	                    autoplay : false, items : 1, rewind: true, nav: true, navText: ["", ""], dots: false, loop : false,
	                    onInitialized : function() {
	                        if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	                            $this.find('img').each(function() {
	                                var $this = $(this);
	                                zoomcfg.zoomContainer = $this.parent();
	                                $this.elevateZoom(zoomcfg);
	                            });
	                        }
	                    },
	                    onTranslate : function(e) {
	                        image_active = this._current - $this.find('.cloned').length / 2;
	                        self.switchImageThumb(null, $product_thumbs, image_active);
	                    },
	                    onRefreshed: function() {
	                        if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	                            $this.find('img').each(function() {
	                                var elevateZoom = $(this).data('elevateZoom');
	                                if (typeof elevateZoom != 'undefined') {
	                                    elevateZoom.startZoom();
	                                    elevateZoom.swaptheimage($(this).attr('src'), $(this).attr('data-src'));
	                                }
	                            });
	                        }
	                    }
	                });
	                $this.parent('.images').addClass('loaded');
	            });
	        });
	    },
	    switchImageThumb: function($product_images, $product_thumbs, index) {
	        if (self.flag_switch) return;
	        self.flag_switch = true;
	        var thumb_leng = $product_thumbs.find('.owl-item').length, thumbs_active = [], i = 0;
	        index = (index + thumb_leng) % thumb_leng;
	        $product_thumbs.find('.owl-item').removeClass('selected');
	        $product_thumbs.find('.owl-item:eq(' + index + ')').addClass('selected');
	        $product_thumbs.data('thumbselected', index);
	        $product_thumbs.find('.owl-item.active').each(function() {
	            thumbs_active[i++] = $(this).index();
	        });
	        // Switch Thumb
	        if ($.inArray(index, thumbs_active) == -1) {
	            if (Math.abs(index - thumbs_active[0]) > Math.abs(index - thumbs_active[thumbs_active.length - 1])) {
	                $product_thumbs.trigger('to.owl.carousel', [(index - thumbs_active.length + 1) % thumb_leng, 300, true]);
	            } else {
	                $product_thumbs.trigger('to.owl.carousel', [index % thumb_leng, 300, true]);
	            }
	        }
	        // Switch Image
	        if ($product_images) {
	            $product_images.trigger('to.owl.carousel', [index, 300, true]);
	        }
	        self.flag_switch = false;
	    }
	};
	// End Class: SnsSinglePrdIHG
	// Begin Class: SnsSinglePrdIVG
	var SnsSinglePrdIVG = {
		init: function( $wrap ) {
			if ( typeof sns_sp_var == 'undefined' ) return false;
	    	if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	    		var zoomcfg = {
		            responsive: true, zoomType: sns_sp_var['zoomtype'], cursor: 'grab'
		        };
		        if ( sns_sp_var['zoomtype'] == 'inner' ) {
		        	zoomcfg.borderSize = 0;
		        }else if ( sns_sp_var['zoomtype'] == 'lens' ) {
		        	zoomcfg.lensSize = sns_sp_var['lenssize']; zoomcfg.lensShape = sns_sp_var['lensshape'];
		        }
	    	}
	    	if ( typeof $wrap == 'undefined') var $wrap = '';
	    	if ( $wrap != '' ) {
	    		$wrap = $wrap+' .product-images';
	    	}else{
	    		$wrap = '.product-images';
	    	}
	        $($wrap).each(function() {
	            var $this = $(this),
	                $product = $this.closest('.product'),
	                $product_thumbs = $product.find('.product-thumbs'),
	                image_active = 0;
	            $this.find('img:first-child').waitForImages(true).done(function() {
		            // Slider for Thumbs
	                $product_thumbs.slick({
						vertical: true,
						asNavFor: '.entry-img .images .product-images',
						focusOnSelect: true,
						infinite: false,
						arrows: true,
						slidesToScroll: 1,
						slidesToShow: ($product_thumbs.find('.img').size()>=4) ? 4 : $product_thumbs.find('.img').size() ,
					});
	                // Button click to popup Images
	                if ( sns_sp_var['poup'] == '1' ) {
	                    var imgsrc = [], imgtitle = [], i = 0;
	                    var $popup_btn = $product.find('.popup-image');
	                    var $popup_video_btn = $product.find('.popup-video');
	                    $this.find('img').each(function() {
	                        imgsrc[i] = $(this).attr('data-src'); imgtitle[i] = $(this).attr('alt'); i++;
	                    });
	                    $this.data('imgsrc', imgsrc); $this.data('imgtitle', imgtitle);
	                    if (typeof $.fn.prettyPhoto !== 'undefined') {
		                    $($popup_btn).off('click').on('click', function(e) {
		                        e.preventDefault();
		                        $.prettyPhoto.open($this.data('imgsrc'), [], $this.data('imgtitle'), image_active);
		                    });
		                    $popup_video_btn.prettyPhoto({
								hook: 'data-rel', default_width: 750, default_height: 600, social_tools: false, theme: 'pp_woocommerce', horizontal_padding: 20, opacity: 0.8, deeplinking: false
							});
		                }
	                }
	                // Zoom for image
	                if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
                        $this.find('img').each(function() {
                            var $this = $(this);
                            zoomcfg.zoomContainer = $this.parent();
                            $this.elevateZoom(zoomcfg);
                        });
                    }
                    // Slider for Images
	                $this.slick({
						vertical: false,
						asNavFor: '.entry-img .thumbnails .product-thumbs',
						focusOnSelect: true,
						infinite: false,
						slidesToScroll: 1,
						slidesToShow: 1,
						arrows: false
					}).on('afterChange', function(event, slick, currentSlide){
						image_active = $this.slick('slickCurrentSlide');
					});
					$this.parent('.images').addClass('loaded');
	            });
	        });
	    }
	};
	// End Class: SnsSinglePrdIVG
	// Begin Class: SnsSinglePrdN1
    var SnsSinglePrdN1 = {
		init: function( $wrap ) {
			var self = this, flag_switch = false;
			if ( typeof sns_sp_var == 'undefined' ) return false;
	    		var zoomcfg = {
		            responsive: true, zoomType: sns_sp_var['zoomtype'], cursor: 'grab'
		        };
		        if ( sns_sp_var['zoomtype'] == 'inner' ) {
		        	zoomcfg.borderSize = 0;
		        }else if ( sns_sp_var['zoomtype'] == 'lens' ) {
		        	zoomcfg.lensSize = sns_sp_var['lenssize']; zoomcfg.lensShape = sns_sp_var['lensshape'];
		        }
	    	if ( typeof $wrap == 'undefined') var $wrap = '';
	    	if ( $wrap != '' ) {
	    		$wrap = $wrap+' .product-images';
	    	}else{
	    		$wrap = '.product-images';
	    	}
	        $($wrap).each(function() {
	            var $this = $(this),
	                $product = $this.closest('.product'),
	                image_active = 0;
	                // Button click to popup Images
	                if ( sns_sp_var['poup'] == '1' ) {
	                    var imgsrc = [], imgtitle = [], i = 0;
	                    var $popup_btn = $product.find('.popup-image');
	                    var $popup_video_btn = $product.find('.popup-video');
	                    $this.find('img').each(function() {
	                        imgsrc[i] = $(this).attr('data-src'); imgtitle[i] = $(this).attr('alt');
	                        i++;
	                    });
	                    $this.data('imgsrc', imgsrc); $this.data('imgtitle', imgtitle);
	                    if (typeof $.fn.prettyPhoto !== 'undefined') {
		                    $($popup_btn).off('click').on('click', function(e) {
		                        e.preventDefault();
		                        $.prettyPhoto.open($this.data('imgsrc'), [], $this.data('imgtitle'), image_active);
		                    });
		                    $popup_video_btn.prettyPhoto({
								hook: 'data-rel', default_width: 750, default_height: 600, social_tools: false, theme: 'pp_woocommerce', horizontal_padding: 20, opacity: 0.8, deeplinking: false
							});
		                }
	                }
	                $this.find('img').each(function() {
                    	zoomcfg.zoomContainer = $(this).parent();
    					$(this).elevateZoom(zoomcfg);
    					$(window).on('resize', function () {
	                            $this.find('img').each(function() {
	                                var elevateZoom = $(this).data('elevateZoom');
	                                if (typeof elevateZoom != 'undefined') {
	                                    elevateZoom.startZoom();
	                                    elevateZoom.swaptheimage($(this).attr('src'), $(this).attr('data-src'));
	                                }
	                            });
	                    });
	                });
	        });
	    },
	};
    // End Class: SnsSinglePrdN1
    // Begin Class: SnsSinglePrdN2
	var SnsSinglePrdN2 = {
		init: function( $wrap ) {
			var self = this, flag_switch = false;
			if ( typeof sns_sp_var == 'undefined' ) return false;
	    	if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	    		var zoomcfg = {
		            responsive: true, zoomType: sns_sp_var['zoomtype'], cursor: 'grab'
		        };
		        if ( sns_sp_var['zoomtype'] == 'inner' ) {
		        	zoomcfg.borderSize = 0;
		        }else if ( sns_sp_var['zoomtype'] == 'lens' ) {
		        	zoomcfg.lensSize = sns_sp_var['lenssize']; zoomcfg.lensShape = sns_sp_var['lensshape'];
		        }
	    	}
	    	if ( typeof $wrap == 'undefined') var $wrap = '';
	    	if ( $wrap != '' ) {
	    		$wrap = $wrap+' .product-images';
	    	}else{
	    		$wrap = '.product-images';
	    	}
	        $($wrap).each(function() {
	            var $this = $(this),
	                $product = $this.closest('.product'),
	                image_active = 0;
	            $this.find('img:first-child').waitForImages(true).done(function() {
	                // Button click to popup Images
	                if ( sns_sp_var['poup'] == '1' ) {
	                    var imgsrc = [], imgtitle = [], i = 0;
	                    var $popup_btn = $product.find('.popup-image');
	                    var $popup_video_btn = $product.find('.popup-video');
	                    $this.find('img').each(function() {
	                        imgsrc[i] = $(this).attr('data-src'); imgtitle[i] = $(this).attr('alt');
	                        i++;
	                    });
	                    $this.data('imgsrc', imgsrc); $this.data('imgtitle', imgtitle);
	                    if (typeof $.fn.prettyPhoto !== 'undefined') {
		                    $($popup_btn).off('click').on('click', function(e) {
		                        e.preventDefault();
		                        $.prettyPhoto.open($this.data('imgsrc'), [], $this.data('imgtitle'), image_active);
		                    });
		                    $popup_video_btn.prettyPhoto({
								hook: 'data-rel', default_width: 750, default_height: 600, social_tools: false, theme: 'pp_woocommerce', horizontal_padding: 20, opacity: 0.8, deeplinking: false
							});
		                }
	                }
	                // Carousel for Images
	                $this.owlCarousel({
	                    autoplay : false, items : 3, rewind: true, nav: true, navText: ["", ""], dots: false, loop : false,
	                    responsive : {
		                    0 : { items:1 },
		                    480 : { items:2 },
		                    768 : { items:2 },
		                    992 : { items:3 },
		                    1200 : { items:3 }
		                },
	                    onInitialized : function() {
	                        if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	                            $this.find('img').each(function() {
	                                var $this = $(this);
	                                zoomcfg.zoomContainer = $this.parent();
	                                $this.elevateZoom(zoomcfg);
	                            });
	                        }
	                    },
	                    onTranslate : function(e) {
	                        image_active = this._current - $this.find('.cloned').length / 2;
	                    },
	                    onRefreshed: function() {
	                        if ( sns_sp_var['zoom'] == '1' && ( !('ontouchstart' in document) || ( ('ontouchstart' in document) && sns_sp_var['zoommobile'] == '1' ) ) ) {
	                            $this.find('img').each(function() {
	                                var elevateZoom = $(this).data('elevateZoom');
	                                if (typeof elevateZoom != 'undefined') {
	                                    elevateZoom.startZoom();
	                                    elevateZoom.swaptheimage($(this).attr('src'), $(this).attr('data-src'));
	                                }
	                            });
	                        }
	                    }
	                });
	                $this.parent('.images').addClass('loaded');
	            });
	        });
	    }
	};
	// End Class: SnsSinglePrdN2
})(jQuery);