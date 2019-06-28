<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="inner-post">
    <?php
    // Post Quote
    if ( get_post_format() == 'quote' && function_exists('rwmb_meta') && rwmb_meta('dsk_post_quotecontent') && rwmb_meta('dsk_post_quoteauthor') ) :
        $uq  = rand().time();
        ?>
        <div class="quote-info quote-info-<?php echo esc_attr($uq); ?>">
            <?php if ( rwmb_meta('dsk_post_quotecontent') ) : ?>
            <div class="quote-content"><i class="fa fa-quote-left"></i> <?php echo esc_html(rwmb_meta('dsk_post_quotecontent')); ?> <i class="fa fa-quote-right"></i></div>
            <?php endif; ?>
             <?php if ( rwmb_meta('dsk_post_quoteauthor') ) : ?>
            <div class="quote-author">- <?php echo esc_html(rwmb_meta('dsk_post_quoteauthor')); ?> -</div>
            <?php endif; ?>
        </div>
    <?php
    // Post Link
    elseif ( get_post_format() == 'link' && function_exists('rwmb_meta') && rwmb_meta('dsk_post_linkurl') ) : 
    ?> 
        <div class="link-info">
            <a title="<?php echo esc_attr(rwmb_meta('dsk_post_linktitle')) ?>" href="<?php echo esc_url( rwmb_meta('dsk_post_linkurl') ) ?>"><?php echo esc_html(rwmb_meta('dsk_post_linktitle')) ?></a>
        </div>
    <?php
    // Post Video
    elseif ( get_post_format() == 'video' && get_post_meta(get_the_id(), 'dsk_post_video', true) ) : 
    ?>
        <div class="video-thumb video-responsive">
            <?php
            echo rwmb_meta('dsk_post_video');
            ?>
        </div>
    <?php
    // Post audio
    elseif ( get_post_format() == 'audio' && get_post_meta(get_the_id(), 'dsk_post_audio', true) ) : ?>
    ?>
        <div class="audio-thumb audio-responsive">
            <?php
            echo wp_oembed_get(esc_attr(rwmb_meta('dsk_post_audio')));
            ?>
        </div>
    <?php
    // Post Gallery
    elseif ( function_exists('rwmb_meta') && rwmb_meta('dsk_post_gallery') ) :
    ?>
        <div class="gallery-thumb">
            <div class="thumb-container owl-carousel">
            <?php
            foreach (rwmb_meta('dsk_post_gallery', 'type=image') as $image) { ?>
                <?php 
                $src = $image['full_url'];
                ?>
               <div class="item"><img alt="<?php echo esc_attr($image['alt']); ?>" src="<?php echo esc_attr($src); ?>"/></div>
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
            $blog_type = dsk_themeoption('blog_type');
            $img_size = 'dsk_blog_default_thumb';
            ?>
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( '%s', 'dsk' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
            <?php
                the_post_thumbnail();
            ?>
            </a>
        </div>
    <?php
    endif;?>
        <?php if(dsk_themeoption('show_categories', 1) == 1 && get_the_category_list() ): ?>
            <span class="cat-links">
                <?php echo get_the_category_list(', '); ?>
            </span>
        <?php endif;?>
        <?php if ( get_the_title() != '' ) : ?>
        <h3 class="post-title second-font">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'dsk' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h3>
        <?php endif;?>
        <div class="post-meta">
            <?php if ( is_sticky() && ! is_paged() && !is_search() ) { ?>
                <span class="sticky-content"><?php echo esc_html__( 'Featured', 'dsk' ) ; ?></span>
            <?php
            } ?>
            <?php if( dsk_themeoption('show_author', 1) == 1 ): ?>
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
            if (dsk_themeoption('show_date', 1) == 1 ) :
                printf( '<span class="entry-date">%1$s<a href="%2$s" rel="bookmark"><time class="entry-date published" datetime="%3$s">%4$s</time></a></span>',
                    esc_html__('On ', 'dsk'),
                    get_permalink(),
                    esc_attr( get_the_date() ),
                    get_the_date()
                );
            endif;
            ?>
            <?php if( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ): ?>
                <span class="post-comment-count">
                <?php
                    echo '<span class="comments-link">';
                    comments_popup_link( esc_html__( '0 Comments','dsk' ),  esc_html__( '1 Comment','dsk' ), '%' . esc_html__(' Comments','dsk'));
                    echo '</span>';
                ?>
                </span>
            <?php endif; ?>
            <?php
            // Edit link
            edit_post_link(esc_html__('Edit','dsk'), '<span class="edit-post">', '</span>'); ?>
        </div>
        <div class="post-content">      
            <div class="post-excerpt">
                <?php
                if ( is_search() ) {
                    the_excerpt();
                }else{
                    if( empty( $post->post_excerpt ) ) {
                        $readmore = '<span>'.esc_html__('Read More', 'dsk').'</span><span class="meta-nav">&#8594;</span>';
                        if ( $post->post_type == 'page' ) {
                            // Trip shortcodes for post type is page on search result page
                            echo strip_shortcodes(get_the_content($readmore));
                        }else{
                            the_content($readmore);
                        }
                        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'dsk' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                    } else { ?>
                        <p class="excerpt"><?php echo dsk_excerpt( (int)dsk_themeoption('excerpt_length', 75) ); ?></p>
                    <?php 
                    }
                } ?>
            </div>
        </div>
    </div>
</article>