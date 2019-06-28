(function ($) {
    "use strict";
	// Save current page
	if(typeof sns.query_vars !== 'undefined'){
		_current_page = sns.query_vars.paged;
	}else{
		_current_page = -1;
	}
	if(_current_page == 0) _current_page = 1;
	// Flag to check if an ajax is executing
	_ajax_loading = false;
	
	function dsk_do_ajax($blog_layout){ 
		if( $('#navigation-ajax').length > 0 ){
			$('#navigation-ajax').live('click', function(e){
			 	e.preventDefault();
				if( _current_page > -1 && !_ajax_loading){
					item_template = $(this).attr('data-template');
					
					data = {
							action: 'load_more',
							page: _current_page,
							template: item_template,
							numload: $(this).attr('data-numload'),
							dsk_blog_layout: $blog_layout,
							vars: sns.query_vars,
					};
					
					content_div = $(this).attr('data-target');
					
					_ajax_loading = true;
					$.ajax({
						type: 'POST',
						url: sns.ajaxurl,
						cache: false,
						data: data,
						success: function(data, textStatus, XMLHttpRequest){
							if(data !=''){
								// Do something fancy before appending data
								$('#navigation-ajax').removeClass('snsnav-active');
								$('#navigation-ajax').html( $('#navigation-ajax').attr('data-label') );
								// Then append data
								
								// blog masonry
								if($('.sns-grid-masonry').length > 0){
									var newItems = $(data).appendTo(content_div);
									$(content_div).masonry('appended', newItems);
									
									var ImagesLoaded = imagesLoaded( document.querySelector(content_div)  );
									ImagesLoaded.on( 'done', function(instance){
										$('.sns-grid-masonry').masonry({
											// options
											itemSelector: '.sns-grid-item',
										});
									});
								}else{
									$(content_div).append(data);
								}
								
								// increase current page
								_current_page = _current_page + 1;
								// Hide button load more if no posts
								if( $('#sns-load-more-no-posts').length > 0 ){
									$('.navigation-ajax').hide();
								}
							}else{
								_current_page = -1;
								// Do something else when there is no more results
								$('.navigation-ajax').hide();
							}
							_ajax_loading = false;

							$(content_div + ' .post-thumb img, ' + content_div + ' .gallery-thumb img').removeAttr('width').removeAttr('height').removeAttr('sizes');
						},
						error: function(MLHttpRequest, textStatus, errorThrown){
							alert(errorThrown);
							_ajax_loading = false;
						}
					});
				}
			});
		}
	}
	function dsk_auto_do_ajax($blog_layout){ 
		if( $('#navigation-ajax').length > 0 ){
			$('#navigation-ajax').each(function(){ 
				if( _current_page > -1 && !_ajax_loading){
					item_template = $(this).attr('data-template');
					
					data = {
							action: 'load_more',
							page: _current_page,
							template: item_template,
							numload: $(this).attr('data-numload'),
							dsk_blog_layout: $blog_layout,
							vars: sns.query_vars,
					};
					
					content_div = $(this).attr('data-target');
					
					_ajax_loading = true;
					$.ajax({
						type: 'POST',
						url: sns.ajaxurl,
						cache: false,
						data: data,
						success: function(data, textStatus, XMLHttpRequest){
							if(data !=''){
								// Do something fancy before appending data
								$('#navigation-ajax').removeClass('snsnav-active');
								$('#navigation-ajax').html( $('#navigation-ajax').attr('data-label') );
								// Then append data
								
								// blog masonry
								if($('.sns-grid-masonry').length > 0){
									var newItems = $(data).appendTo(content_div);
									$(content_div).masonry('appended', newItems);
									
									var ImagesLoaded = imagesLoaded( document.querySelector(content_div)  );
									ImagesLoaded.on( 'done', function(instance){
										$('.sns-grid-masonry').masonry({
											// options
											itemSelector: '.sns-grid-item',
										});
									});
								}else{
									$(content_div).append(data);
								}
								
								// increase current page
								_current_page = _current_page + 1;
								// Hide button load more if no posts
								if( $('#sns-load-more-no-posts').length > 0 ){
									$('.navigation-ajax').hide();
								}
							}else{
								_current_page = -1;
								// Do something else when there is no more results
								$('.navigation-ajax').hide();
							}
							_ajax_loading = false;

							$(content_div + ' .post-thumb img, ' + content_div + ' .gallery-thumb img').removeAttr('width').removeAttr('height').removeAttr('sizes');
						},
						error: function(MLHttpRequest, textStatus, errorThrown){
							alert(errorThrown);
							_ajax_loading = false;
						}
					});
				}
			});
		}
	}
	$(document).ready(function($){
		if( $('#navigation-ajax').length > 0 ){
			var $dsk_blog_layout = $('input[name="hidden_dsk_blog_layout"]').val();
			if ( $('#navigation-ajax').hasClass('click-load') ) {
				$('#navigation-ajax').on('click', function() {
					// Do something before loading
					$(this).addClass('snsnav-active'); $(this).html( $(this).attr('data-labelload') );
					dsk_do_ajax($dsk_blog_layout);

				});
			}else{
				$(window).scroll(function() {
					var scrollBottom = $(window).scrollTop() + $(window).height();
					var navTop = $('#navigation-ajax').offset().top;
					if ( navTop + $('#navigation-ajax').outerHeight() <= scrollBottom ) {
						setTimeout(function(){
							$('#navigation-ajax').addClass('snsnav-active'); $(this).html( $(this).attr('data-labelload') );
							dsk_auto_do_ajax($dsk_blog_layout);
						}, 800);
					}
				});
			}
		}
	});
})(jQuery);