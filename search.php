<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
			<?php do_action('dsk_in_sns_content'); ?>
			<?php dsk_leftcol(); ?>
			<div class="<?php echo dsk_maincolclass(); ?>">
			    <?php
			    if ( have_posts() ) : ?>
	            <div id="snsmain" class="blog-standard posts sns-blog-posts">
	            	<?php
	                // Theloop
	                while ( have_posts() ) : the_post();
	                    get_template_part( 'framework/tpl/posts/post' );
	                endwhile;
	            	?>
	            </div>
	            <?php
		            // Paging
		            get_template_part('tpl-paging');
	            else:
	               echo esc_html__('No post were found matching your selection', 'dsk');
	            endif; ?>
			</div>
			<?php dsk_rightcol(); ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>