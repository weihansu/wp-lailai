<?php // Template Name: Side page(demo shortcodes) 
?>
<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
			<?php do_action('dsk_in_sns_content'); ?>
			<div class="col-md-3 sns-left">
				<aside class="widget">
					<h3 class='sidebar-shortcodes'><span><?php echo esc_html__('Shortcodes Demo','dsk'); ?></span></h3>
				    <ul class="side-navigation">
		            <?php 	
						$post_ancestors = get_post_ancestors($post->ID);
						$post_parent = end($post_ancestors);
						if($post_parent) {
							wp_list_pages("title_li=&child_of=".esc_url($post_parent)."&echo=0");
						} else {
							wp_list_pages("title_li=&child_of=".esc_url($post->ID)."&echo=0");
						}
					?>
		            </ul>
				</aside>
			</div>
			<div class="col-md-9 sns-main main-right">
			    <?php
			    if ( have_posts() ) :
			        get_template_part( 'framework/tpl/page/content' );
			    else:
			        get_template_part( 'content', 'none' );
			    endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>