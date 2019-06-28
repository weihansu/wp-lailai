<?php
$author_bio_avatar_size = apply_filters('100', '100');
if ( get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size ) !=''
	|| get_the_author_meta('display_name') != ''
	) :
?>
<div class="author-info">
	<?php if ( get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size ) !='' ) :?>
	<div class="author-avatar">
		<?php
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div>
	<?php endif; ?>
	<?php if ( get_the_author_meta('display_name') != '' || get_the_author_meta( 'description' ) != '' ) :?>
	<div class="author-description">
		<?php if ( get_the_author_meta('display_name') != '' ) : ?>
		<h4 class="author-title">
			<?php printf( wp_kses(__( '<a class="author-link" href="%s" ref="author">%s</a>', 'dsk' ), array(
										'a' => array(
											'href' => array(),
											'class' => array(),
											'ref' => array()
										),
										) ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),  get_the_author_meta('display_name') ); ?>
		</h4>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'description' ) != '' ) : ?>
		<p class="author-bio">
			<span class="author-desc"><?php the_author_meta( 'description' ); ?></span>
		</p>
		<?php endif; ?>
	</div><!-- .author-description -->
	<?php endif; ?>
</div>
<?php endif; ?>