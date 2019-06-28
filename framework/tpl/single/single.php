<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    // Post Quote
    if ( get_post_format() == 'quote' && function_exists('rwmb_meta') && rwmb_meta('dsk_post_quotecontent') && rwmb_meta('dsk_post_quoteauthor') ) :
        $uq  = rand().time();
        ?>
        <div class="quote-info quote-info-<?php echo esc_attr($uq); ?> post-thumb">
            <?php if ( rwmb_meta('dsk_post_quotecontent') ) : ?>
            <div class="quote-content"><i class="fa fa-quote-left"></i> <?php echo esc_html(rwmb_meta('dsk_post_quotecontent')); ?> <i class="fa fa-quote-right"></i></div>
            <?php endif; ?>
             <?php if ( rwmb_meta('dsk_post_quoteauthor') ) : ?>
            <div class="quote-author">- <?php echo esc_html(rwmb_meta('dsk_post_quoteauthor')); ?> -</div>
            <?php endif; ?>
        </div>
    <?php
    // Post Link
    elseif ( get_post_format() == 'link' && function_exists('rwmb_meta') && rwmb_meta('dsk_post_linkurl') ) : ?>
        <div class="link-info">
            <a title="<?php echo esc_attr(rwmb_meta('dsk_post_linktitle')) ?>" href="<?php echo esc_url( rwmb_meta('dsk_post_linkurl') ) ?>"><?php echo esc_html(rwmb_meta('dsk_post_linktitle')) ?></a>
        </div>
    <?php
    // Post Video
    elseif ( get_post_format() == 'video' && get_post_meta(get_the_id(), 'dsk_post_video', true) ) : 
    ?>
        <div class="video-thumb video-responsive">
            <?php
            echo wp_oembed_get(esc_attr(get_post_meta(get_the_id(), 'dsk_post_video', true)));
            ?>
        </div>
    <?php
    // Post Audio
    elseif ( get_post_format() == 'audio' && get_post_meta(get_the_id(), 'dsk_post_audio', true) ) : 
    ?>
        <div class="audio-thumb audio-responsive">
            <?php
            echo wp_oembed_get(esc_attr(get_post_meta(get_the_id(), 'dsk_post_audio', true)));
            ?>
        </div>
    <?php
    // Post Gallery
    elseif ( function_exists('rwmb_meta') && rwmb_meta('dsk_post_gallery') ) :
    ?>
        <div class="gallery-thumb">
            <div class="thumb-container owl-carousel">
            <?php
            foreach (rwmb_meta('dsk_post_gallery', 'type=image') as $image) {?>
               <div class="item"><img alt="<?php echo esc_attr($image['alt']); ?>" src="<?php echo esc_attr($image['full_url']); ?>"/></div>
            <?php
            }
            ?>
            </div>
        </div>
    <?php
    // Post Image
    elseif ( has_post_thumbnail() ) : ?>
        <div class="post-thumb">
            <?php
           the_post_thumbnail();
            ?>
        </div>
    <?php
    endif;?>
    <?php if( get_the_category_list() ):?>
        <span class="cat-links">
            <?php echo get_the_category_list(', '); ?>
        </span>
    <?php endif;?>
    <?php if ( get_the_title() != '' ) : ?>
    <h1 class="post-title second-font">
        <?php the_title(); ?>
    </h1>
    <?php endif;?>
    <div class="post-meta">
        <?php if ( dsk_themeoption('show_postauthor') ) : ?>
            <span class="post-author">
            <?php
            echo esc_html__('Post by ', 'dsk');
            printf( wp_kses(__( '<a class="author-link" href="%s" ref="author">%s</a>', 'dsk' ), array(
                            'a' => array(
                                'href' => array(),
                                'class' => array(),
                                'ref' => array()
                            ),
                            ) ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author_meta('display_name') ); ?>
            </span>
        <?php endif; ?>
        <?php
        // Date
        printf( '<span class="entry-date">%1$s<a href="%2$s" rel="bookmark"><time class="entry-date published" datetime="%3$s">%4$s</time></a></span>',
            esc_html__('On ', 'dsk'),
            get_permalink(),
            esc_attr( get_the_date() ),
            get_the_date()
        );
        ?>
        <?php
        // Edit link
        edit_post_link(esc_html__('Edit','dsk'), '<span class="edit-post">', '</span>'); ?>
    </div>
    
    <div class="post-content">
        <div class="content">
            <?php 
            the_content();
            // Post Paging
            wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'dsk' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
            ?>
        </div>
    </div><!-- /.post-content -->
    
    <?php
    if ( dsk_themeoption('show_postsharebox') || get_the_tag_list() ) :?>
    <div class="post-foot">
        <?php if( get_the_tag_list() ): ?>
            <span class="tags-links">
                <?php the_tags('<span>Tags:</span>', ''); ?>
            </span>
        <?php endif; ?>
        <?php
        if ( dsk_themeoption('show_postsharebox') ) :
           dsk_sharebox();
        endif;
        ?>
    </div>
    <?php endif; ?>
    <?php
    // Author bio
    if ( dsk_themeoption('show_postauthor') && get_the_author_meta( 'description' ) ) :
        get_template_part( 'author-bio' );
    endif;
    // Post navigation.
    dsk_post_nav();
    ?>
    <?php 
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
    comments_template();
    endif;
    ?>
</article>