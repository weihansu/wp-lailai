<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
			<?php do_action('dsk_in_sns_content'); ?>
			<?php dsk_leftcol(); ?>
			<div class="<?php echo dsk_maincolclass(); ?>">
			    <?php
			    // Start the loop.
			    if(have_posts()):
					while ( have_posts() ) : the_post();
						dsk_set_post_views(get_the_ID());
		        		get_template_part( 'framework/tpl/single/single', get_post_format() );
			      	endwhile;
			      else:
			      	get_template_part( 'content', 'none' );
			      endif;
			    ?>
			</div>
			<?php dsk_rightcol(); ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>