<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php dsk_pagetitle(true); ?>
    <?php
    while ( have_posts() ) : the_post();
        the_content();
        // Post Paging
        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'dsk' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    endwhile;
    ?>
</section>