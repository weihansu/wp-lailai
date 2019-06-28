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
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1 class="post-title">
					        <?php the_title(); ?>
					    </h1>
					    <div class="post-meta">
					        <?php
					        // Date
					        printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date published" datetime="%2$s">%3$s</time></a></span>',
		                        get_permalink(),
		                        esc_attr( get_the_date() ),
		                        get_the_date()
		                    );
					        ?>
					        <?php
					        // Edit link
					        edit_post_link(esc_html__('Edit','dsk'), '<span class="edit-post">', '</span>'); ?>
					    </div>
					    
						<div class="entry-attachment">
							<?php
								echo wp_get_attachment_image( get_the_ID(), 'large' );
							?>
							<?php if ( has_excerpt() ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

						</div>
						<nav id="image-navigation" class="navigation image-navigation">
							<div class="nav-links">
								<div class="nav-previous"><?php previous_image_link( false, esc_html__( 'Previous Image', 'dsk' ) ); ?></div><div class="nav-next"><?php next_image_link( false, esc_html__( 'Next Image', 'dsk' ) ); ?></div>
							</div>
						</nav>
					    <?php
					    // Post Comment
					    if ( comments_open() || get_comments_number() ) :
					        comments_template();
					    endif;
					    ?>
					</article>
				<?php
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