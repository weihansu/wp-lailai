<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
			<?php do_action('dsk_in_sns_content'); ?>
			<?php dsk_leftcol(); ?>
			<div class="<?php echo dsk_maincolclass(); ?>">
			    <?php
			    if ( have_posts() ) :
			        get_template_part( 'framework/tpl/blog/blog', dsk_themeoption('blog_type', '') );
			    else:
			        get_template_part( 'content', 'none' );
			    endif; ?>
			</div>
			<?php dsk_rightcol(); ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>