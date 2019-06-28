<?php
if( $relates->have_posts() ): ?>
	<h2 class="related-title second-font">
        <span><?php echo esc_html__( 'Related Post', 'dsk' ); ?></span>
    </h2>
    <div class="related-content"><div class="owl-carousel">
		<?php
		while ( $relates->have_posts() ) : $relates->the_post();
        ?>
            <div class="item">
                <?php if ( has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="image">
                        <?php the_post_thumbnail('dsk_blog_large_thumb'); ?>
                    </a>
                <?php endif; ?>
                 <h3 class="title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
            </div>
        <?php
        endwhile; ?>
    </div></div>
    <?php
endif;
?>